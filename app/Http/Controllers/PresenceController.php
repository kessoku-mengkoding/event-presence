<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Presence;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function index_view($timetable_id)
    {
        $presences = Presence::with('user')->where('timetable_id', $timetable_id)->get();

        return view('presences.index', [
            'title' => 'Presences',
            'presences' => $presences,
            'timetable' => Timetable::where('id', $timetable_id)->first()
        ]);
    }

    public function get_device_info(Request $request)
    {
        return view('presences.get-device-info', [
            'group_id' => $request->input('group_id'),
            'timetable_id' => $request->input('timetable_id'),
            'title' => 'Get Device Information'
        ]);
    }

    public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function presence_redirect(Request $request)
    // "/presences/get-device-information?group_id=&timetable_id="
    {
        date_default_timezone_set('Asia/Makassar');
        $datetime_now = date("Y-m-d H:i:s");

        $timetable = Timetable::where("id", $request->timetable_id)
            ->where("group_id", $request->group_id)->first();

        // !! validate presence. time, location, etc
        // validate location
        $is_valid = true;
        $distance = $this->haversineGreatCircleDistance($timetable->latitude, $timetable->longitude, $request->lat, $request->long);
        if ($distance > $timetable->radius_meter) {
            $is_valid = false;
        }

        // validate time
        if ($timetable->start > $datetime_now) {
            return redirect()->with('message', 'Presence for this timetable has not opened yet');
        }
        $status = $timetable->end < $datetime_now ? 'late' : 'on time';

        $groupmember = GroupMember::with('user')->where('group_id', $request->group_id)
            ->where('user_id', Auth::id())
            ->first();

        $is_presence_before = Presence::where('groupmember_id', $groupmember->id)
            ->where('timetable_id', $request->timetable_id)
            ->first();
        if ($is_presence_before) {
            return redirect('/timetables/' . $timetable->id . '/scan-me')->with('message', 'You already do presence before');
        }

        $presence = new Presence();
        $presence->user_id = $groupmember->user->id;
        $presence->groupmember_id = $groupmember->id;
        $presence->timetable_id = $timetable->id;
        $presence->status = $status; // check time
        $presence->is_valid = $is_valid; // check location
        $presence->latitude = $request->lat;
        $presence->longitude = $request->long;
        $presence->save();

        return redirect('/')->with('message', 'Presence success');
    }

    public function history_view()
    {
        $user_presences = User::with(['presences.timetable', 'presences.groupmember.group'])
                                ->where('id', Auth::id())
                                ->first();

        return view('presences.history', [
            'user' => $user_presences,
            'title' => 'History'
        ]);
    }
}

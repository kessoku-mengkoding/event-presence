<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Presence;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresenceController extends Controller
{
    public function get_device_info(Request $request)
    {
        return view('presences.get-device-info', [
            'group_id' => $request->input('group_id'),
            'timetable_id' => $request->input('timetable_id'),
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
        if($distance > $timetable->radius_meter) {
            $is_valid = false;
        }

        // validate time
        if($timetable->start > $datetime_now) {
            return redirect()->with('message', 'Presence for this timetable has not opened yet');
        }
        $status = $timetable->end < $datetime_now ? 'late' : 'on time';

        $groupmember = GroupMember::where('group_id', $request->group_id)
                            ->where('user_id', Auth::id())->first();

        $presence = new Presence();
        $presence->groupmember_id = $groupmember->id;
        $presence->timetable_id = $timetable->id;
        $presence->status = $status; // check time
        $presence->is_valid = $is_valid; // check location
        $presence->latitude = $request->lat;
        $presence->longitude = $request->long;
        $presence->save();

        return redirect('/')->with('message', 'Presence success');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\Presence;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class TimetableController extends Controller
{
    public function createView($event_id)
    {
        $event = Event::where('id', $event_id)->first();

        return view('timetables.new', [
            'event_id' => $event_id,
            'event' => $event,
            'title' => 'New Timetable'
        ]);
    }

    public function createFromAdminView($event_id)
    {
        $event = Event::where('id', $event_id)->first();

        return view('admin.timetables.create', [
            'event_id' => $event_id,
            'event' => $event,
            'title' => 'New Timetable'
        ]);
    }

    public function indexAdminView($id)
    {
        $timetables = Timetable::where('event_id', $id)->orderBy('created_at', 'desc')->get();
        $event = Event::where('id', $id)->first();
        $now = HelperController::getDatetimeNow();

        return view('admin.timetables.index', [
            'timetables' => $timetables,
            'event' => $event,
            'now' => $now,
        ]);
    }

    public function detailAdminView($id)
    {
        $timetable = Timetable::where('id', $id)->first();
        $event = Event::where('id', $timetable->event_id)->first();
        $eventmembers = EventMember::with('user.resident')->where('event_id', $timetable->event_id)->get();
        $presences = Presence::with('user.resident')->where('timetable_id', $id)->get();

        // penduduk yang belum absen
        $eventmembers_not_presence = EventMember::with('user.resident')->where('event_id', $timetable->event_id)->get();
        foreach ($eventmembers_not_presence as $key => $eventmember) {
            foreach ($presences as $presence) {
                if ($eventmember->user_id == $presence->user_id) {
                    unset($eventmembers_not_presence[$key]);
                }
            }
        }

        $presence_controller = new PresenceController();
        $presences_location_distance = [];

        $presences_late_duration = [];

        foreach ($presences as $presence) {
            $presences_late_duration[] = $presence->created_at->diffInMinutes($timetable->end);
            $presences_location_distance[] = round($presence_controller->haversineGreatCircleDistance(
                $presence->latitude,
                $presence->longitude,
                $timetable->latitude,
                $timetable->longitude
            ), 1) / 10;
        }

        $timetable_status = 'Ended';
        if ($timetable->start > HelperController::getDatetimeNow()) {
            $timetable_status = 'Upcoming';
        } else if ($timetable->start < HelperController::getDatetimeNow() && $timetable->end > HelperController::getDatetimeNow()) {
            $timetable_status = 'Ongoing';
        }

        return view('admin.timetables.detail', [
            'timetable' => $timetable,
            'timetable_status' => $timetable_status,
            'event' => $event,
            'eventmembers' => $eventmembers,
            'eventmembers_not_presence' => $eventmembers_not_presence,
            'presences' => $presences,
            'presences_late_duration' => $presences_late_duration,
            'presences_location_distance' => $presences_location_distance
        ]);
    }

    public function editView($id)
    {
        $timetable = Timetable::where('id', $id)->first();
        $event = Event::where('id', $timetable->event_id)->first();

        return view('admin.timetables.edit', [
            'timetable' => $timetable,
            'event' => $event,
            'title' => 'Edit Timetable'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'lat' => 'required|numeric|gte:-90|lte:90',
            'long' => 'required|numeric|gte:-1800|lte:180',
            // 'address' => 'required|string',
            'radius_meter' => 'required|numeric|gt:0',
            'lateness_tolerance' => 'required|numeric|gte:0',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'event_id' => 'required',
        ]);

        $timetable = new Timetable();
        $timetable->title = $request->title;
        $timetable->latitude = $request->lat;
        $timetable->longitude = $request->long;
        $timetable->address = $request->address;
        $timetable->radius_meter = $request->radius_meter;
        $timetable->lateness_tolerance = $request->lateness_tolerance;
        $timetable->start = $request->start;
        $timetable->end = $request->end;
        $timetable->event_id = $request->event_id;
        $timetable->created_by = Auth::id();
        $timetable->save();

        $redirect_url = env('APP_COMPLETE_URL') . "/presences/get-device-information?event_id=" . $request->event_id . "&timetable_id=" . $timetable->id;
        $imageController = new ImageController();
        $qr_code_path = $imageController->generateQrUrl($redirect_url);
        $timetable->qr_code_path = $qr_code_path;
        $timetable->save();

        return redirect('/admin/timetables/' . $request->event_id)->with('message', 'Jadwal berhasil dibuat');
    }

    public function scanQRView($timetable_id)
    {
        return view('timetables.scan-me', [
            'title' => 'Scan me',
            'timetable' => Timetable::with('event')->where('id', $timetable_id)->first(),
            'previous_url' => URL::previous()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'lat' => 'required|numeric|gte:-90|lte:90',
            'long' => 'required|numeric|gte:-1800|lte:180',
            // 'address' => 'required|string',
            'radius_meter' => 'required|numeric|gt:0',
            'lateness_tolerance' => 'required|numeric|gte:0',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'event_id' => 'required',
        ]);

        Timetable::where('id', $request->id)->update([
            'title' => $request->title,
            'latitude' => $request->lat,
            'longitude' => $request->long,
            'address' => $request->address,
            'radius_meter' => $request->radius_meter,
            'lateness_tolerance' => $request->lateness_tolerance,
            'start' => $request->start,
            'end' => $request->end,
            'event_id' => $request->event_id,
        ]);

        return redirect()->route('timetablesAdminView', $request->event_id)->with('message', 'Jadwal berhasil diubah');
    }

    public function delete($id)
    {
        Timetable::where('id', $id)->delete();

        return back()->with('message', 'Jadwal berhasil dihapus');
    }
}

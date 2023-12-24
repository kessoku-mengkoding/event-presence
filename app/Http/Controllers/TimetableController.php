<?php

namespace App\Http\Controllers;

use App\Models\Event;
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

    public function indexAdminView($id)
    {
        $timetables = Timetable::with('event')->where('event_id', $id)->get();
        return view('admin.timetables.index', compact('timetables'));
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

        // create notif
        // NotificationController::create(Auth::id(), '', 'New timetable has been created', 'timetable', []);

        return redirect('/events/' . $request->event_id . '/detail')->with('message', 'Timetable created');
    }

    public function scanQRView($timetable_id)
    {
        return view('timetables.scan-me', [
            'title' => 'Scan me',
            'timetable' => Timetable::with('event')->where('id', $timetable_id)->first(),
            'previous_url' => URL::previous()
        ]);
    }

    public function delete($id)
    {
        Timetable::where('id', $id)->delete();

        return back()->with('message', 'Timetable deleted');
    }
}

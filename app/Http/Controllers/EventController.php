<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\Invitation;
use App\Models\Notification;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function indexView()
    {
        $eventmembers = EventMember::with(['event', 'event.eventmembers'])->where('user_id', Auth::id())->get();

        return view('events.index', [
            'title' => 'Events',
            'eventmembers' => $eventmembers
        ]);
    }

    public function createView()
    {
        return view('events.create', [
            'title' => 'Create Event'
        ]);
    }

    public function detailView($id)
    {
        $event = Event::with('eventmembers')->find($id);
        $user_in_event = DB::table('eventmembers')
            ->where('event_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $pendings = Invitation::with(['user'])
            ->where('event_id', $id)
            ->get();

        $timetables = Timetable::where('event_id', $id)->get();

        return view('events.detail', [
            'title' => 'Event Detail',
            'event' => $event,
            'user_in_event' => $user_in_event,
            'superuser' => ['admin', 'owner'],
            'pendings' => $pendings,
            'timetables' => $timetables
        ]);
    }

    public function joinView()
    {
        return view('events.join', [
            'title' => 'Join Event'
        ]);
    }

    public function scanQRView()
    {
        return view("events.scan");
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => ''
        ]);

        // handle image
        $image_link = NULL;
        if ($request->file('image')) {
            $image_link = ImageController::uploadToExternalQRService($request);
        }

        // create event
        $event = new Event();
        $event->name = $request->name;
        $event->image_path = $image_link;
        $event->description = $request->description;
        $event->save();

        // create qr team to join automatically
        $redirect_join_url = "/events/join/redirect?event_id=" . $event->id;
        $qr_code_path = ImageController::generateQrUrl($redirect_join_url);
        $event->qr_code_path = $qr_code_path;
        $event->save();

        // add user to event as eventmember
        $eventmember = new EventMember();
        $eventmember_data = [
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'role' => 'owner',
        ];
        $eventmember->fill($eventmember_data);
        $eventmember->save();

        return redirect('/events')->with('message', 'Event created');
    }

    public function join(Request $request)
    {
        $event = DB::select('SELECT id FROM events WHERE id = ?', [$request->id]);
        if (!$event) {
            return back()->with('message', 'Event not found');
        }

        $already_join = DB::select('SELECT id FROM eventmembers WHERE user_id = ? && event_id = ?', [Auth::id(), $request->id]);
        if ($already_join) {
            return back()->with('message', 'You alredy join this event before');
        }

        $eventMember = new EventMember();
        $eventMember->user_id = Auth::id();
        $eventMember->event_id = $request->id;
        $eventMember->save();

        return redirect('/events/' . $request->id . '/detail')->with("message", "Success join event");
    }

    public function joinRedirect(Request $request)
    {
        // yyy.com/events/join/redirect?event_id=

        $event = DB::select('SELECT id FROM events WHERE id = ?', [$request->input("event_id")]);
        if (!$event) {
            return back()->with('message', 'Event not found');
        }

        $already_join = DB::select('SELECT id FROM eventmembers WHERE user_id = ? && event_id = ?', [Auth::id(), $request->input("event_id")]);
        if ($already_join) {
            if (url()->previous() == env('APP_COMPLETE_URL') . "/events/join/scan") {
                return redirect("/events/join")->with('message', 'You already join this event before');
            }
            return back()->with('message', 'You already join this event before');
        }

        $eventMember = new EventMember();
        $eventMember->user_id = Auth::id();
        $eventMember->event_id = $request->input("event_id");
        $eventMember->save();

        return redirect('/events/' . $request->input("event_id") . '/detail')->with("message", "Success join event");
    }

    public function joinByUploadQR(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if (!$request->file('image')) {
            return back()->with('message', 'Something went wrong');
        }

        $url = ImageController::uploadToExternalQRService($request);

        $response = Http::post(env('QR_SERVICE_URL') . '/read', ['url' => $url]);
        $redirect_url = $response->body();

        return strpos($redirect_url, '/events/join/redirect?event_id=') !== false
            ? redirect($redirect_url)
            : back()->with("message", "Event not found");
    }

    public function delete($id)
    {
        DB::delete('DELETE FROM events WHERE id = ?', [$id]);
        return redirect('/events')->with('message', 'Event deleted');
    }
}

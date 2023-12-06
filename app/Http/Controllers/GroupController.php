<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventMember;
use App\Models\Invitation;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class EventController extends Controller
{
    public function index_view()
    {
        $eventmembers = EventMember::with(['event', 'event.eventmembers'])->where('user_id', Auth::id())->get();

        return view('events.index', [
            'title' => 'Events',
            'eventmembers' => $eventmembers
        ]);
    }

    public function create_view()
    {
        return view('events.create', [
            'title' => 'Create Event'
        ]);
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
            $image_link = ImageController::upload_external($request);
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
        $event_member = new EventMember();
        $groum_member_data = [
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'role' => 'owner',
        ];
        $event_member->fill($groum_member_data);
        $event_member->save();

        return redirect('/events')->with('message', 'Event created');
    }

    public function detail($id)
    {
        $event = Event::with('eventmembers')->find($id);
        $user_in_event = DB::table('eventmembers')
            ->where('event_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $pendings = Invitation::with(['user'])
            ->where('event_id', $id)
            ->get();

        $timetable = new TimetableController();
        $timetables = $timetable->filter_by_event($id);

        return view('events.detail', [
            'title' => 'Event Detail',
            'event' => $event,
            'user_in_event' => $user_in_event,
            'superuser' => ['admin', 'owner'],
            'pendings' => $pendings,
            'timetables' => $timetables
        ]);
    }

    public function join_view(Request $request)
    {
        return view('events.join', [
            'title' => 'Join Event'
        ]);
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

    public function join_redirect(Request $request)
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

    public function join_by_upload_qr(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if (!$request->file('image')) {
            return back()->with('message', 'Something went wrong');
        }

        $url = ImageController::upload_external($request);

        $response = Http::post(env('QR_SERVICE_URL') . '/read', [
            'url' => $url
        ]);
        $redirect_url = $response->body();

        if (strpos($redirect_url, '/events/join/redirect?event_id=') !== false) {
            return redirect($redirect_url);
        } else {
            return back()->with("message", "Event not found");
        }
    }

    public function scan()
    {
        return view("events.scan");
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM events WHERE id = ?', [$id]);
        return redirect('/events')->with('message', 'Event deleted');
    }
}

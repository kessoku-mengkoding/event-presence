<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use App\Models\Timetable;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function indexAdminView()
    {
        if (request()->search) {
            $users = User::with('resident')->where('name', 'like', '%' . request()->search . '%')
                ->orWhere('username', 'like', '%' . request()->search . '%')
                ->orWhere('email', 'like', '%' . request()->search . '%')
                ->get();
        } else {
            $users = User::with('resident')->get();
        }

        return view('admin.users.index', [
            'users' => $users,
            'is_search' => request()->search ? true : false,
            'search_value' => request()->search,
        ]);
    }

    public function homeView(Request $request)
    {
        $type = $request->input('type');

        $user = User::where('id', Auth::id())->first();
        $timetables = User::with(['eventmembers.event.timetables'])
            ->where('id', Auth::id())
            ->first();

        $timezone = new DateTimeZone('Asia/Makassar'); // UTC+8
        $now = new DateTime('now', $timezone);
        $currentDateTime = $now->format('Y-m-d H:i:s');

        $helper = new HelperController();

        $event_ids = array();
        foreach ($timetables->eventmembers as $member) {
            foreach ($member->event->timetables as $timetable) {
                $timetable->is_presence = Presence::where('eventmember_id', $member->id)
                    ->where('timetable_id', $timetable->id)
                    ->exists();

                array_push($event_ids, $member->event->id);

                $IS_ONGOING = $currentDateTime >= $timetable->start && $currentDateTime <= $timetable->end;
                $IS_UPCOMING = $currentDateTime < $timetable->start;

                if ($IS_ONGOING) {
                    $time_dif = $helper->calculateDatetimeDifference($currentDateTime, $timetable->end);
                    $timetable->status = 'ongoing';
                    $timetable->time_description = $time_dif . ' left';
                } else if ($IS_UPCOMING) {
                    $time_dif = $helper->calculateDatetimeDifference($currentDateTime, $timetable->start);
                    $timetable->status = 'upcoming';
                    $timetable->time_description = $time_dif . ' to start';
                } else {
                    $time_dif = $helper->calculateDatetimeDifference($currentDateTime, $timetable->end);
                    $timetable->status = 'missed';
                    $timetable->time_description = $time_dif . ' ago';
                }
            }
        }

        $event_ids = array_unique($event_ids);
        $recent_timetables = Timetable::with('event')
            ->whereIn('event_id', $event_ids)
            ->orderBy('created_at', 'desc')
            ->get();

        // count all timetables
        $all_timetables_count = 0;
        foreach ($timetables->eventmembers as $member) {
            $all_timetables_count += count($member->event->timetables);
        }

        return view('home', [
            'type' => $type,
            'user' => $user,
            'title' => 'Home',
            'timetables' => $timetables,
            'time' => $currentDateTime,
            'recent_timetables' => $recent_timetables,
            'all_timetables_count' => $all_timetables_count,
        ]);
    }

    public function editFromAdminView($id)
    {
        $user = User::with('resident')->find($id);
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    public function reminderView()
    {
        return view('home.reminder', [
            'title' => 'Reminder'
        ]);
    }

    public function ongoingView()
    {
        return view('home.ongoing', [
            'title' => 'Ongoing'
        ]);
    }

    public function upcomingView()
    {
        return view('home.upcoming', [
            'title' => 'Upcoming'
        ]);
    }

    public function profileView(string $id)
    {
        if ($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);

        return view('account.profile', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function editView($id)
    {
        if ($id == 'me') {
            $id = Auth::id();
        }
        $user = User::with('resident')->find($id);
        return view('account.edit', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function passwordView($id)
    {
        if ($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);
        return view('account.password', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function update(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $user->update($request->all());

        return back()->with('message', 'Update profile success');
    }

    public function delete()
    {
        $id = Auth::id();
        User::destroy($id);

        return redirect('/sign-in');
    }

    public function deleteFromAdmin(Request $request)
    {
        User::destroy($request->id);

        return back()->with('message', 'Delete user success');
    }

    public function editFromAdmin(Request $request)
    {
        if($request->new_password) {
            $request->merge([
                'password' => bcrypt($request->new_password)
            ]);
        }

        $user = User::find($request->id);
        $user->update($request->all());

        return back()->with('message', 'Update user success');
    }
}

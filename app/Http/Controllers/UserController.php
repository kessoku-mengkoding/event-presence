<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Timetable;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        $user = User::where('id', Auth::id())->first();
        $timetables = User::with(['groupmembers.group.timetables'])
                    ->where('id', Auth::id())
                    ->first();

        $timezone = new DateTimeZone('Asia/Taipei'); // UTC+8
        $now = new DateTime('now', $timezone);
        $currentDateTime = $now->format('Y-m-d H:i:s');

        if($type == 'ongoing') {
            $temp = $timetables->groupmembers->map(function($groupmember) use ($currentDateTime) {
                return $groupmember->group->timetables->filter(function($timetable) use ($currentDateTime) {
                    return $timetable->start_time <= $currentDateTime && $timetable->end_time >= $currentDateTime;
                });
            });
            $timetables = $temp->flatten();
            dd($timetables);
        }

        if($type == 'upcoming') {

        }

        return view('home', [
            'type' => $type,
            'user' => $user,
            'title' => 'Home',
            'timetables' => $timetables
        ]);
    }

    public function reminder() {
        return view('home.reminder', [
            'title' => 'Reminder'
        ]);
    }

    public function ongoing() {
        return view('home.ongoing', [
            'title' => 'Ongoing'
        ]);
    }

    public function upcoming() {
        return view('home.upcoming', [
            'title' => 'Upcoming'
        ]);
    }

    public function profile_view(string $id) {
        if($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);

        return view('account.profile', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function edit_view($id) {
        if($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);
        return view('account.edit', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function password_view($id) {
        if($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);
        return view('account.password', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function update(Request $request) {
        $id = Auth::id();
        $user = User::find($id);
        $user->update($request->all());

        return back()->with('message', 'Update profile success');
    }

    public function destroy() {
        $id = Auth::id();
        User::destroy($id);

        return redirect('/sign-in');
    }
}

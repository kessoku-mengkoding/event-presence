<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Presence;
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

        $timezone = new DateTimeZone('Asia/Makassar'); // UTC+8
        $now = new DateTime('now', $timezone);
        $currentDateTime = $now->format('Y-m-d H:i:s');

        $helper = new HelperController();

        $group_ids = array();
        foreach ($timetables->groupmembers as $member) {
            foreach ($member->group->timetables as $timetable) {
                $timetable->is_presence = Presence::where('groupmember_id', $member->id)
                                        ->where('timetable_id', $timetable->id)
                                        ->exists();

                array_push($group_ids, $member->group->id);

                if ($currentDateTime >= $timetable->start && $currentDateTime <= $timetable->end) {
                    $time_dif = $helper->calculateDatetimeDifference($currentDateTime, $timetable->end);
                    $timetable->status = 'ongoing';
                    $timetable->time_description = $time_dif . ' left';
                } else if ($currentDateTime < $timetable->start) {
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

        $group_ids = array_unique($group_ids);
        $recent_timetables = Timetable::with('group')
                                        ->whereIn('group_id', $group_ids)
                                        ->orderBy('created_at','desc')
                                        ->get();

        return view('home', [
            'type' => $type,
            'user' => $user,
            'title' => 'Home',
            'timetables' => $timetables,
            'time' => $currentDateTime,
            'recent_timetables' => $recent_timetables
        ]);
    }

    public function reminder()
    {
        return view('home.reminder', [
            'title' => 'Reminder'
        ]);
    }

    public function ongoing()
    {
        return view('home.ongoing', [
            'title' => 'Ongoing'
        ]);
    }

    public function upcoming()
    {
        return view('home.upcoming', [
            'title' => 'Upcoming'
        ]);
    }

    public function profile_view(string $id)
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

    public function edit_view($id)
    {
        if ($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);
        return view('account.edit', [
            'user' => $user,
            'title' => 'Profile',
        ]);
    }

    public function password_view($id)
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

    public function destroy()
    {
        $id = Auth::id();
        User::destroy($id);

        return redirect('/sign-in');
    }
}

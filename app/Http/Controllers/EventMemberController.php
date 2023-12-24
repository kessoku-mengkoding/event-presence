<?php

namespace App\Http\Controllers;

use App\Models\EventMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventMemberController extends Controller
{
    public function addMembersView($event_id)
    {
        $event = DB::table('events')->where('id', $event_id)->first();
        // get user include resident where user not in eventmembers
        $users = User::with('resident')->whereNotIn('id', function ($query) use ($event_id) {
            $query->select('user_id')->from('eventmembers')->where('event_id', $event_id);
        })->get();

        return view('admin.events.add-members', [
            'title' => 'Add Members',
            'event' => $event,
            'users' => $users
        ]);
    }

    public function addMembers(Request $request)
    {
        $eventmembers = [];
        foreach ($request->user_ids as $user_id) {
            array_push($eventmembers, [
                'id' => Str::uuid(),
                'event_id' => $request->event_id,
                'user_id' => $user_id,
            ]);
        }
        EventMember::insert($eventmembers);

        return redirect('/admin/events/' . $request->event_id . '/detail')->with('message', 'Success adding ' . count($eventmembers) . ' member');
    }

    public function delete($event_id, $member_id)
    {
        DB::table('eventmembers')
            ->where('event_id', $event_id)
            ->where('user_id', $member_id)
            ->delete();

        return redirect('/events/' . $event_id . '/detail');
    }

    public function changeRole($event_id, $member_id, Request $request)
    {
        dd($request->all());
        DB::table('eventmembers')
            ->where('event_id', $event_id)
            ->where('user_id', $member_id)
            ->update(['role' => $request->role]);

        return redirect('/events/' . $event_id . '/detail');
    }
}

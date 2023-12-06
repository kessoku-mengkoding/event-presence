<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventMemberController extends Controller
{
    public function destroy($event_id, $member_id)
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupMemberController extends Controller
{
    public function destroy($group_id, $member_id)
    {
        DB::table('groupmembers')
            ->where('group_id', $group_id)
            ->where('user_id', $member_id)
            ->delete();

        return redirect('/groups/'. $group_id .'/detail');
    }

    public function changeRole($group_id, $member_id, Request $request)
    {
        dd($request->all());
        DB::table('groupmembers')
            ->where('group_id', $group_id)
            ->where('user_id', $member_id)
            ->update(['role' => $request->role]);

        return redirect('/groups/'. $group_id .'/detail');
    }
}

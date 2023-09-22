<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::with(['group', 'groupmember.user'])
                        ->where('user_id', Auth::id())
                        ->get();

        return view('invitation', ['invitations' => $invitations]);
    }

    public function create($group_id, Request $request)
    {
        // can't invite self
        if($request->user_id == Auth::id()) {
            return;
        }

        // can't invite user that already joined
        $groupmember = DB::table('groupmembers')
                        ->where('group_id', $group_id)
                        ->where('user_id', $request->user_id)
                        ->first();
        if($groupmember) {
            return;
        }

        // can't invite user that already invited
        $invitedUser = DB::table('invitations')
                        ->where('group_id', $group_id)
                        ->where('user_id', $request->user_id)
                        ->first();
        if($invitedUser) {
            return;
        }

        $inviter_groupmember = DB::table('groupmembers')
                                    ->where('group_id', $group_id)
                                    ->where('user_id', Auth::id())
                                    ->first();

        $invitation = new Invitation();
        $invitation->user_id = $request->user_id;
        $invitation->group_id = $group_id;
        $invitation->invited_by_groupmember_id = $inviter_groupmember->id;
        $invitation->save();

        return redirect('/groups/'.$group_id.'/detail');
    }

    public function accept($id, Request $request) {
        //create groupmember
        $groupMember = new GroupMember();
        $groupMember->user_id = Auth::id();
        $groupMember->group_id = $request->group_id;
        $groupMember->save();

        //delete invitation
        DB::delete('DELETE FROM invitations WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Invitation accepted');
    }

    public function decline($id) {
        DB::delete('DELETE FROM invitations WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Invitation declined');
    }
}

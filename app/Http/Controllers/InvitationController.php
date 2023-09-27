<?php

namespace App\Http\Controllers;

use App\Models\GroupMember;
use App\Models\Invitation;
use App\Models\User;
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

        return view('invitation', [
            'title' => 'Invitations',
            'invitations' => $invitations
        ]);
    }

    public function create($group_id, Request $request)
    {
        $helper = new HelperController();
        $is_email = $helper->is_valid_email($request->key);

        // check is user exist
        $user = User::where($is_email ? 'email' : 'username', $request->key)->first();
        if(!$user) {
            return back()->with('message', 'User not found');
        }

        // can't invite user that already join
        $already_join = GroupMember::where('user_id', $user->id)
                                    ->where('group_id', $group_id)
                                    ->first();
        if($already_join) {
            return back()->with('message', 'User alredy in this group');
        }

        // can't invite user that already invited
        $invitedUser = DB::table('invitations')
                        ->where('group_id', $group_id)
                        ->where('user_id', $request->user_id)
                        ->first();
        if($invitedUser) {
            return back()->with('message', 'User already invited to this group');
        }

        // get invitor groupmem id
        $invitor_groupmember = GroupMember::where('group_id', $group_id)
                                    ->where('user_id', Auth::id())
                                    ->first();

        $invitation = new Invitation();
        $invitation->user_id = $user->id;
        $invitation->group_id = $group_id;
        $invitation->invited_by_groupmember_id = $invitor_groupmember->id;
        $invitation->save();

        return redirect()->back()->with('success', 'Invite success');
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

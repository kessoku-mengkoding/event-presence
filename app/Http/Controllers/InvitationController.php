<?php

namespace App\Http\Controllers;

use App\Models\EventMember;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::with(['event', 'eventmember.user'])
            ->where('user_id', Auth::id())
            ->get();

        return view('invitation', [
            'title' => 'Invitations',
            'invitations' => $invitations
        ]);
    }

    public function create($event_id, Request $request)
    {
        $helper = new HelperController();
        $is_email = $helper->is_valid_email($request->key);

        // check is user exist
        $user = User::where($is_email ? 'email' : 'username', $request->key)->first();
        if (!$user) {
            return back()->with('message', 'User not found');
        }

        // can't invite user that already join
        $already_join = EventMember::where('user_id', $user->id)
            ->where('event_id', $event_id)
            ->first();
        if ($already_join) {
            return back()->with('message', 'User alredy in this event');
        }

        // can't invite user that already invited
        $invitedUser = DB::table('invitations')
            ->where('event_id', $event_id)
            ->where('user_id', $request->user_id)
            ->first();
        if ($invitedUser) {
            return back()->with('message', 'User already invited to this event');
        }

        // get invitor eventmem id
        $invitor_eventmember = EventMember::where('event_id', $event_id)
            ->where('user_id', Auth::id())
            ->first();

        $invitation = new Invitation();
        $invitation->user_id = $user->id;
        $invitation->event_id = $event_id;
        $invitation->invited_by_eventmember_id = $invitor_eventmember->id;
        $invitation->save();

        return redirect()->back()->with('success', 'Invite success');
    }

    public function accept($id, Request $request)
    {
        //create eventmember
        $eventMember = new EventMember();
        $eventMember->user_id = Auth::id();
        $eventMember->event_id = $request->event_id;
        $eventMember->save();

        //delete invitation
        DB::delete('DELETE FROM invitations WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Invitation accepted');
    }

    public function decline($id)
    {
        DB::delete('DELETE FROM invitations WHERE id = ?', [$id]);

        return redirect()->back()->with('success', 'Invitation declined');
    }
}

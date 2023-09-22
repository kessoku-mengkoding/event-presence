<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Invitation;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function indexCreate()
    {
        return view('create-group');
    }

    public function create(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->save();

        $group_member = new GroupMember();
        $groum_member_data = [
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => 'owner',
        ];
        $group_member->fill($groum_member_data);
        $group_member->save();

        return redirect('/groups/'. $group->id .'/detail');
    }

    public function detail($id)
    {
        $group = Group::with('groupmembers')->find($id);
        $user_in_group = DB::table('groupmembers')
                ->where('group_id', $id)
                ->where('user_id', Auth::id())
                ->first();

        $pendings = Invitation::with(['user'])
                        ->where('group_id', $id)
                        ->get();

        $timetable = new TimetableController();
        $timetables = $timetable->getListInGroup($id);

        return view('group-detail', [
            'group' => $group,
            'user_in_group' => $user_in_group,
            'superuser' => ['admin', 'owner'],
            'pendings' => $pendings,
            'timetables' => $timetables
        ]);
    }

    public function join(Request $request)
    {
        $groupMember = new GroupMember();
        $groupMember->user_id = Auth::id();
        $groupMember->group_id = $request->id;
        $groupMember->save();

        return redirect('/groups/'. $request->id .'/detail');
    }

    public function invite($id, Request $request)
    {
        $notification = new Notification();
        $notification->title = 'Group Invitation';
        $notification->message = 'Youre invited to some group';
        $notification->accept_link = '/';
        $notification->reject_link = '/';
        $notification->save();

        return redirect('/groups/'. $request->id .'/detail');
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM groups WHERE id = ?', [$id]);
        $userController = new UserController();
        return $userController->index();
    }
}

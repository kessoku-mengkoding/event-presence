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
use Illuminate\Support\Facades\Http;

class GroupController extends Controller
{
    public function index()
    {
        $groupmembers = GroupMember::with('group')->where('user_id', Auth::id())->get();

        return view('groups.index', [
            'title' => 'Groups',
            'groupmembers' => $groupmembers
        ]);
    }

    public function indexCreate()
    {
        return view('groups.create', [
            'title' => 'Create Group'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => ''
        ]);

        // handle image
        $image_controller = new ImageController();
        if($request->file('image')){
            $image_link = $image_controller->upload_external($request);
        }

        // create group
        $group = new Group();
        $group->name = $request->name;
        $group->image_path = $image_link ?? NULL;
        $group->description = $request->description;
        $group->save();

        // create qr team to join automatically

        $redirect_join_url = "/groups/join/redirect?group_id=" . $group->id;
        $qr_code_path = $image_controller->generateQrUrl($redirect_join_url);
        $group->qr_code_path = $qr_code_path;
        $group->save();

        // add user to group as groupmember
        $group_member = new GroupMember();
        $groum_member_data = [
            'user_id' => Auth::id(),
            'group_id' => $group->id,
            'role' => 'owner',
        ];
        $group_member->fill($groum_member_data);
        $group_member->save();

        return redirect('/groups')->with('message', 'Group created');
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

        return view('groups.detail', [
            'title' => 'Group Detail',
            'group' => $group,
            'user_in_group' => $user_in_group,
            'superuser' => ['admin', 'owner'],
            'pendings' => $pendings,
            'timetables' => $timetables
        ]);
    }

    public function join_view(Request $request) {
        return view('groups.join', [
            'title' => 'Join Group'
        ]);
    }

    public function join(Request $request)
    {
        $group = DB::select('SELECT id FROM groups WHERE id = ?', [$request->id]);
        if(!$group) {
            return back()->with('message', 'Group not found');
        }

        $already_join = DB::select('SELECT id FROM groupmembers WHERE user_id = ? && group_id = ?', [Auth::id(), $request->id]);
        if($already_join) {
            return back()->with('message', 'You alredy join this group before');
        }

        $groupMember = new GroupMember();
        $groupMember->user_id = Auth::id();
        $groupMember->group_id = $request->id;
        $groupMember->save();

        return redirect('/groups/'. $request->id .'/detail')->with("message", "Success join group");
    }

    public function join_redirect(Request $request)
    {
        // yyy.com/groups/join/redirect?group_id=

        $group = DB::select('SELECT id FROM groups WHERE id = ?', [$request->input("group_id")]);
        if(!$group) {
            return back()->with('message', 'Group not found');
        }

        $already_join = DB::select('SELECT id FROM groupmembers WHERE user_id = ? && group_id = ?', [Auth::id(), $request->input("group_id")]);
        if($already_join) {
            if(url()->previous() == env('APP_COMPLETE_URL') . "/groups/join/scan") {
                return redirect("/groups/join")->with('message', 'You already join this group before');
            }
            return back()->with('message', 'You already join this group before');
        }

        $groupMember = new GroupMember();
        $groupMember->user_id = Auth::id();
        $groupMember->group_id = $request->input("group_id");
        $groupMember->save();

        return redirect('/groups/'. $request->input("group_id") .'/detail')->with("message", "Success join group");
    }

    public function join_by_upload_qr(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if (!$request->file('image')) {
            return back()->with('message', 'Something went wrong');
        }

        $image_controller = new ImageController();
        $url = $image_controller->upload_external($request);

        $response = Http::get('http://localhost:5000/read?url=' . $url);
        $redirect_url = $response->body();

        if (strpos($redirect_url, '/groups/join/redirect?group_id=') !== false) {
            return redirect($redirect_url);
        } else {
            return back()->with("message", "Group not found");
        }
    }

    public function scan()
    {
        return view("groups.scan");
    }

    public function destroy($id)
    {
        DB::delete('DELETE FROM groups WHERE id = ?', [$id]);
        return redirect('/groups')->with('message', 'Group deleted');
    }
}

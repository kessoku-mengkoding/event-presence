<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $groups = GroupMember::with('group')->where('user_id', Auth::id())->get();
        $user = User::where('id', Auth::id())->first();
        return view('home', [
            'groups' => $groups,
            'user' => $user,
            'title' => 'Home'
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

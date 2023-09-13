<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index() {
        $groups = GroupMember::with('group')->where('user_id', Auth::id())->get();
        return view('home', ['groups' => $groups]);
    }

    public function profile(string $id) {
        if($id == 'me') {
            $id = Auth::id();
        }
        $user = User::find($id);

        return view('profile', ['user' => $user]);
    }

    public function update(Request $request) {
        $id = Auth::id();
        $user = User::find($id);
        $user->update($request->all());

        return redirect("/profile/me");
    }

    public function destroy() {
        $id = Auth::id();
        User::destroy($id);

        return redirect('/login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function forgot_password_view()
    {
        return view('auth.forgot-password');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
           'email' => 'email:dns|required',
           'password' => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('message', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/sign-in')->with('message', 'Logout success');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return back()->with("message", "Old password doesn't match!");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("message", "Password changed successfully!");
    }
}

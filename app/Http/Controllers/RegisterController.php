<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5',
            'confirm_password' => 'required',
        ]);

        if($validatedData['password'] != $validatedData['confirm_password']) {
            return redirect()->back()->withInput()->withErrors(['confirm_password' => 'Confirm password does not match']);
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect('/login')->with('regis_success', 'Registration Success');
    }
}

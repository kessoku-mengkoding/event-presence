<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexView()
    {
        return view('admin.dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }
}

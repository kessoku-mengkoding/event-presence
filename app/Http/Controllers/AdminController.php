<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexView()
    {
        return view('admin.index', [
            'title' => 'Admin Dashboard'
        ]);
    }
}

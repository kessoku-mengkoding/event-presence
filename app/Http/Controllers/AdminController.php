<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexView()
    {
        $now = HelperController::getDatetimeNow();
        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'now' => $now
        ]);
    }
}

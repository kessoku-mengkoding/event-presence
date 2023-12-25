<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function indexView()
    {
        $now = HelperController::getDatetimeNow();
        $total_residents = Resident::count();
        $total_events = Event::count();
        $total_users = User::count();

        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'now' => $now,
            'total_residents' => $total_residents,
            'total_events' => $total_events,
            'total_users' => $total_users,
        ]);
    }
}

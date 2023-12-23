<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function indexView()
    {
        $residents = Resident::all();
        return view('admin.residents.index', compact('residents'));
    }
}

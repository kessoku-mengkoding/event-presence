<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function indexView()
    {
        return view('admin.residents.index');
    }
}

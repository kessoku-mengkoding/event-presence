<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResidentController extends Controller
{
    public function indexView()
    {
        $residents = Resident::all();
        return view('admin.residents.index', compact('residents'));
    }

    public function createView()
    {
        return view('admin.residents.create');
    }

    public function create(Request $request)
    {
        $resident = new Resident();
        $resident->id = Str::uuid();
        $resident->full_name = $request->full_name;
        $resident->nik = $request->nik;
        $resident->kk = $request->kk;
        $resident->address = $request->address;
        $resident->save();

        return back()->with('message', 'Penduduk berhasil ditambahkan');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ResidentController extends Controller
{
    public function indexView()
    {
        if (request()->search) {
            $residents = Resident::where('full_name', 'like', '%' . request()->search . '%')
                ->orWhere('nik', 'like', '%' . request()->search . '%')
                ->orWhere('kk', 'like', '%' . request()->search . '%')
                ->orWhere('address', 'like', '%' . request()->search . '%')
                ->get();
        } else {
            $residents = Resident::all();
        }

        return view('admin.residents.index', [
            'residents' => $residents,
            'is_search' => request()->search ? true : false,
            'search_value' => request()->search,
        ]);
    }

    public function createView()
    {
        return view('admin.residents.create');
    }

    public function editView($id)
    {
        $resident = Resident::where('id', $id)->first();
        return view('admin.residents.edit', compact('resident'));
    }

    public function update(Request $request)
    {
        Resident::where('id', $request->id)->update([
            'full_name' => $request->full_name,
            'nik' => $request->nik,
            'kk' => $request->kk,
            'address' => $request->address,
        ]);

        return back()->with('message', 'Penduduk berhasil diubah');
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

    public function delete(Request $request)
    {
        Resident::where('id', $request->id)->delete();
        return back()->with('message', 'Penduduk berhasil dihapus');
    }
}

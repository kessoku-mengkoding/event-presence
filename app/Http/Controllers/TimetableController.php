<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function viewCreate($group_id)
    {
        $group = Group::where('id', $group_id)->first();
        return view('timetables.new', [
            'group_id' => $group_id,
            'group' => $group,
            'title' => 'New Timetable'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'lat' => 'required|numeric|gte:-90|lte:90',
            'long' => 'required|numeric|gte:-1800|lte:180',
            'address' => 'required|string',
            'radius_meter' => 'required|numeric|gt:0',
            'lateness_tolerance' => 'required|numeric|gte:0',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'group_id' => 'required',
        ]);

        $timetable = new Timetable();
        $timetable->title = $request->title;
        $timetable->latitude = $request->lat;
        $timetable->longitude = $request->long;
        $timetable->address = $request->address;
        $timetable->radius_meter = $request->radius_meter;
        $timetable->lateness_tolerance = $request->lateness_tolerance;
        $timetable->start = $request->start;
        $timetable->end = $request->end;
        $timetable->group_id = $request->group_id;
        $timetable->created_by = Auth::id();
        $timetable->save();

        return redirect('/groups/'. $request->group_id .'/detail')->with('message', 'Timetable created');
    }

    public function getListInGroup($group_id)
    {
        return Timetable::where('group_id', $group_id)->get();
    }

    public function delete($id) {
        Timetable::where('id', $id)->delete();

        return back()->with('message', 'Timetable deleted');
    }
}

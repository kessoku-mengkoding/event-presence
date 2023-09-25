<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function viewCreate($group_id)
    {
        return view('new-timetable', [
            'group_id' => $group_id
        ]);
    }

    public function create(Request $request)
    {
        $timetable = new Timetable();
        $timetable->title = $request->title;
        $timetable->description = $request->description;
        $timetable->location = $request->location;
        $timetable->radius_meter = $request->radius_meter;
        $timetable->start_date = $request->start_date;
        $timetable->end_date = $request->end_date;
        $timetable->group_id = $request->group_id;
        $timetable->created_bt = $request->created_by_user_id;
        $timetable->save();

        return redirect()->back()->with('success', 'Timetable created');
    }

    public function getListInGroup($group_id)
    {
        return Timetable::where('group_id', $group_id)->get();
    }
}

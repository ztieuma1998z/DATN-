<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleClassController extends Controller
{
    public function index($id)
    {
        $class = ClassModel::find($id);
        $schedules = Schedule::with('course:id,name')
            ->with('class:id,name')
            ->with('shift:id,name,start_at,end_at')
            ->with('room:id,name')
            ->with('weekday:id,name')
            ->where('class_id', $id)
            ->orderBy('date')
            ->orderBy('shift_id')
            ->get();

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("Y-m-d");
        $time = date('H:i:s');

        $scheduleToday = Schedule::with('shift:id,name,start_at,end_at')
            ->where('class_id', $id)
            ->where('date', $date)
            ->get();

        $scheduleIds = [];

        foreach ($scheduleToday as $value) {
            if (isset($value->shift->start_at) && isset($value->shift->end_at)) {
                if ($value->shift->start_at <= $time && $time <= $value->shift->end_at) {
                    array_push($scheduleIds, $value->id);
                }
            }
        }

        return view('teacher.schedulebyclass.index', compact('schedules', 'class', "scheduleIds", "date"));
    }
}

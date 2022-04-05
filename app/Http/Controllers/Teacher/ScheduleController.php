<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = \Auth::user()->id;

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");
        $day = $request->day;

        $schedules = Schedule::with('course:id,name')
                            ->with('teacher:id,full_name')
                            ->with('class:id,name')
                            ->with('shift:id,name,start_at,end_at')
                            ->with('room:id,name')
                            ->with('weekday:id,name')
                            ->where('teacher_id', $teacherId);

        if($day) {
            if ($day == "today") {
                $schedules = $schedules->where('date', '=', $today);
            }else{
                $numberDate = date("Y-m-d", strtotime("$day day", strtotime($today)));
                if($numberDate>$today) {
                    $schedules = $schedules->where('date', '>=', $today)
                        ->where('date', '<=', $numberDate);
                }else{
                    $schedules = $schedules->where('date', '<=', $today)
                        ->where('date', '>=', $numberDate);
                }
            }

        }else{
            $schedules = $schedules->where('date', '>=', $today);
        }

        $schedules = $schedules->orderBy('date')
                            ->orderBy('shift_id')
                            ->get();
        return view('teacher.schedule.index', compact('schedules'));
    }
}

<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\RollCall;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RollCallController extends Controller
{
    public function index($idSchedule, $idClass)
    {
        $class = ClassModel::find($idClass);
        $schedule = Schedule::find($idSchedule);

        $students = RollCall::select('student_id')
            ->where('schedule_id',$idSchedule)
            ->where('class_id',$idClass)
            ->get();

        $studentIds = [];

        foreach ($students as $value) {
            array_push($studentIds, $value->student_id);
        }

        if($class) {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $date = date("Y-m-d");
            $time = date('H:i:s');


            $classStudents = ClassStudent::with('student:id,avatar,full_name,code')
                ->where('class_id', $idClass)
                ->get();


            $scheduleToday = Schedule::with('shift:id,name,start_at,end_at')
                ->where('class_id', $idClass)
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

            return view('teacher.rollcall.index',compact('class', 'schedule', 'classStudents', 'studentIds', 'scheduleIds'));
        }

        return redirect()->back()->with('error', 'Lớp không tồn tại !');
    }
}

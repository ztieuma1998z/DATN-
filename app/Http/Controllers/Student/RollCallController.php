<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\RollCall;
use App\Models\Schedule;
use Illuminate\Http\Request;

class RollCallController extends Controller
{
    public function index()
    {
        $studentId = \Auth::user()->id;
        $classStudent = ClassStudent::select('class_id')->where('student_id',$studentId)->get()->toArray();

        $classIds =  \Arr::flatten($classStudent);

        $classes = ClassModel::with('course:id,name')->whereIn('id',$classIds)->get();

        $schedules = Schedule::with('class:id,name')
            ->with('shift:id,name,start_at,end_at')
            ->with('room:id,name')
            ->with('weekday:id,name')
            ->with('rollCall:schedule_id,student_id,teacher_id,user_id')
            ->whereIn('class_id', $classIds)
            ->orderBy('date')
            ->orderBy('shift_id')
            ->get();

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $date = date("Y-m-d");
        $time = date('H:i:s');


        $numberAbsences = [];
        foreach ($classIds as $item) {
            $rollCall = RollCall::where('class_id',$item)
                                ->where('student_id', $studentId)
                                ->get()->count();

            $scheduleRollCall = Schedule::where('class_id', $item)
                                    ->where('date', '<', $date)
                                    ->get()
                                    ->count();

            $numberSessions = Schedule::where('class_id', $item)->get()->count();

            $total = $scheduleRollCall - $rollCall;
            array_push($numberAbsences,[
                'class_id' => $item,
                'absences' => $total,
                'numberSessions' => $numberSessions
            ]);
        }

        return view('student.rollcall.index', compact('classes', 'schedules', 'date', 'time', 'numberAbsences'));
    }
}

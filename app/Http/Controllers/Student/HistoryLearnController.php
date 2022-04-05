<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryLearnController extends Controller
{
    public function index()
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");
        $studentId = \Auth::user()->id;

        $classHistory = DB::table('classes')
            ->where('classes.end_date','<', $today)
            ->where('class_student.student_id', $studentId)
            ->join('class_student', 'classes.id', '=', 'class_student.class_id')
            ->join('courses', 'courses.id', '=', 'classes.course_id')
            ->join('teachers', 'teachers.id', '=', 'classes.teacher_id')
            ->select('classes.*', 'courses.name as course_name', 'teachers.full_name')
            ->get()
            ->unique('classes.id');

        return view('student.historylearn.index', compact('classHistory'));
    }
}

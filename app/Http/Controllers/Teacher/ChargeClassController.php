<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use Illuminate\Http\Request;

class ChargeClassController extends Controller
{
    public function index()
    {
        $teacherId = \Auth::user()->id;
        $classes = ClassModel::with('course:id,name')
                            ->where("teacher_id", $teacherId)
                            ->orderBy('id', 'desc')
                            ->get();

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");

        return view('teacher.chargeclass.index', compact("classes", "today"));
    }

    public function showListStudentClass(Request $request)
    {
        if($request->ajax()) {
            $classId = $request->classId;

            $students = ClassStudent::with('student:id,code,avatar,full_name,gender,email,phone,birth_date')
                                    ->where('class_id', $classId)->get();

            $html = view('teacher.component.ajax.list-student-by-class', compact('students'))->render();
            return response()->json(['html' => $html]);
        }
    }
}

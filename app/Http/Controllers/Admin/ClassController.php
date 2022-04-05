<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestClass;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\Course;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index (Request $request)
    {
        $kw_name = $request->kw_name;
        $kw_course = $request->kw_course;
        $kw_status = $request->kw_status;
        $kw_start_date = $request->kw_start_date;
        $kw_end_date = $request->kw_end_date;

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");

        $classes = ClassModel::with('course:id,name')->with('classStudent:class_id');
        if(trim($kw_name)){
            $classes->where('name','like','%'.$kw_name.'%' );
        }

        if($kw_course){
            $classes->where('course_id',$kw_course);
        }

        if($kw_status === "1"){
            $classes->where('status',$kw_status)->where('end_date','>=', $today);
        }

        if ($kw_status === "2") {
            $classes->where('end_date','<', $today);
        }

        if ($kw_status === "3") {
            $classes->where('end_date',null);
        }

        if($kw_start_date){
            $classes->where('start_date','>=', $kw_start_date);
        }

        if($kw_end_date){
            $classes->where('end_date','<=', $kw_end_date);
        }

        $classes = $classes->orderByDesc('id')
            ->paginate(10);
        $courses = Course::all();
        return view('admin.class.index', compact('classes', 'courses', 'today'));
    }

    public function create ()
    {
        $courses  = Course::all();
        $viewData = [
            'courses' => $courses,
        ];
         return view('admin.class.add_edit', $viewData);
    }

    public function store (RequestClass $request)
    {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $data = $request->except('_token');
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");
        ClassModel::insert($data);

        return redirect()->route('get.class.index')->with('success', 'Thêm mới lớp học thành công !');
    }

    public function edit ($id)
    {
        $class = ClassModel::find($id);
        $courses = Course::all();
        if(empty($class))
        {
            return redirect()->back()->with('error', 'Lớp học không tồn tại !');
        }
        return view('admin.class.add_edit', compact('class', 'courses'));
    }

    public function update (RequestClass $request, $id)
    {
        if($id)
        {
            $class = ClassModel::find($id);
            if(empty($class)) return redirect()->back()->with('error', 'Lớp học không tồn tại !');
        }

        if($class->end_date){
            $class->name = $request->name;
            $class->population = $request->population;
            $class->course_id = $request->course_id;
            $class->save();
        }else {
            $data = $request->except("_token");
            $data['updated_at'] = Carbon::now();
            $class->update($data);
        }

        return redirect()->route('get.class.index')->with('success', 'Cập nhật lớp học thành công !');
    }

    public function schedule ($id)
    {
        if ($id) {
            $class = ClassModel::find($id);

            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $date = date("Y-m-d");
            $time = date('H:i:s');

            $schedules = Schedule::with('course:id,name')
                                ->with('teacher:id,full_name')
                                ->with('class:id,name')
                                ->with('shift:id,name,start_at,end_at')
                                ->with('room:id,name')
                                ->with('weekday:id,name')
                                ->where('class_id', $id)
                                ->orderBy('date')
                                ->orderBy('shift_id')
                                ->get();

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

            $numberLearnedArr = Schedule::with('shift:id,name,start_at,end_at')
                            ->where('class_id', $id)
                            ->where('date', '<=',$date)
                            ->get();

            $numberLearned = $numberLearnedArr->count();

            foreach ($numberLearnedArr->toArray() as $numLear) {
                if ($numLear['shift']['end_at'] > $time && $date == $numLear['date']) {
                    $numberLearned = $numberLearned - 1;
                }
            }

            return view('admin.class.schedule', compact("schedules", "class", "scheduleIds", "date", "time", "numberLearned"));
        }

        return redirect()->back()->with('error', 'Lớp không tồn tại !');
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

    public function getNumberSession(Request $request)
    {
        if ($request->ajax()) {
            $courseId = $request->courseId;

            $course = Course::find($courseId);
            $number = $course->number_of_sessions;

            return response()->json(['number' => $number]);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Specialized;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TeachingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $kw_name = $request->kw_name;
        $kw_course = $request->kw_course;
        $kw_status_schedule = $request->kw_status_schedule;
        $kw_status_teacher = $request->kw_status_teacher;


        $classes = ClassModel::with('course:id,name')
                            ->with('teacher:id,full_name');

        if(trim($kw_name)){
            $classes->where('name','like','%'.$kw_name.'%' );
        }

        if($kw_course){
            $classes->where('course_id',$kw_course);
        }

        if($kw_status_schedule>=0 && $kw_status_schedule !=null){
            if($kw_status_schedule == 1) $classes->where('end_date','!=', null);
            if($kw_status_schedule == 0) $classes->where('end_date','=', null);
        }

        if($kw_status_teacher>=0 && $kw_status_teacher !=null){
            if($kw_status_teacher == 1) $classes->where('teacher_id','!=', null);
            if($kw_status_teacher == 0) $classes->where('teacher_id','=', null);
        }

        $classes = $classes->orderByDesc('id')
                    ->paginate(10);

        $courses = Course::all();
        return view('admin.teachingschedule.index', compact('classes', 'courses'));
    }

    public function showModalTeachingSchedule(Request $request)
    {
        if ($request->ajax()) {
            $classId = $request->id;
            $class  = ClassModel::with('course:id,name,specialized_id')->find($classId);

            // show time schedule modal by class
            $schedules = Schedule::with('shift:id,name,start_at,end_at')
                                ->with('room:id,name')
                                ->with('weekday:id,name')
                                ->where('class_id', $classId)
                                ->select('shift_id', 'room_id','weekday_id')
                                ->orderBy('weekday_id')
                                ->get()->toArray();
            $scheduleArr = array_unique($schedules, SORT_REGULAR);

            // take all classes whose start date is less than the end of the teacher's placement
            $classes = ClassModel::where('end_date', '>=', $class->start_date)
                                ->where('id', '!=', $classId)
                                ->select('id')
                                ->get();
            $classIds = [];

            foreach ($classes as $value) {
                array_push($classIds, $value->id);
            }
            // check show teacher by schedule
            $scheduleByTeacher = Schedule::with('shift:id,name,start_at,end_at')
                                        ->with('room:id,name')
                                        ->with('weekday:id,name')
                                        ->with('teacher:id,full_name')
                                        ->where('teacher_id', '!=', null)
                                        ->whereIn('class_id', $classIds)
                                        ->select('shift_id', 'room_id','weekday_id', 'teacher_id')
                                        ->get()->toArray();
            $scheduleByTeacher = array_unique($scheduleByTeacher, SORT_REGULAR);

            // search id teacher same schedule
            $teacherIds = [];
            foreach ($scheduleArr as $schedule) {
                foreach ($scheduleByTeacher as $scheduleTeacher) {
                    if(
                        $schedule['shift_id'] == $scheduleTeacher['shift_id'] &&
                        $schedule['weekday_id'] == $scheduleTeacher['weekday_id']
                    ) {
                        array_push($teacherIds, $scheduleTeacher['teacher_id']);
                    }
                }
            }
            $teacherIds = array_unique($teacherIds, SORT_REGULAR);

            $teachers = Teacher::with('specialized:id,name')
                                ->where('status', 1)
                                ->where('specialized_id', $class->course->specialized_id)
                                ->get();

            $html = view('admin.component.ajax.teachingschedule.modal-teaching-schedule', compact('class','scheduleArr', 'teachers', 'teacherIds'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function saveModalTeachingSchedule(Request $request)
    {
        if ($request->ajax()) {
            if($request->teacher_id == null && $request->classId == null){
                return response()->json(['error' => "Vui chọn giáo viên"]);
            }else {
                $teacherId = $request->teacher_id;
                $classId = $request->classId;

                try {
                    $class = ClassModel::find($classId);
                    $class->teacher_id = $teacherId;
                    $class->save();

                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                    $today = date("Y-m-d");

                    Schedule::where('class_id', '=', $classId)
                        ->where('date', '>=', $today)
                        ->update(['teacher_id' => $teacherId]);

                    Session::put('success', 'Xếp giáo viên thành công !');
                    return response()->json(['success' => true]);
                } catch (\Exception $exception) {
                    return back()->withError($exception->getMessage())->withInput();
                }
            }
        }
    }

    public function showDetailTeachingSchedule(Request $request)
    {
        if ($request->ajax()) {
            $classId = $request->id;
            $class  = ClassModel::with('course:id,name')
                                ->with('teacher:id,full_name')
                                ->find($classId);

            // show time schedule modal by class
            $schedules = Schedule::with('shift:id,name,start_at,end_at')
                ->with('room:id,name')
                ->with('weekday:id,name')
                ->where('class_id', $classId)
                ->select('shift_id', 'room_id','weekday_id')
                ->orderBy('weekday_id')
                ->get()->toArray();
            $scheduleArr = array_unique($schedules, SORT_REGULAR);

            // get all classStudent by classId
            $classStudent = ClassStudent::where('class_id', $classId)->get();

            $html = view('admin.component.ajax.teachingschedule.detail-teaching-schedule', compact('class','scheduleArr', 'classStudent'))->render();
            return response()->json(['html' => $html]);
        }
    }
}

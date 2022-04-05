<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentClassController extends Controller
{
    public function index(Request $request, $id)
    {
        $class = ClassModel::with('course:id,name')->find($id);

        $classStudent = ClassStudent::with('student:id,full_name,code,gender,phone,email,avatar')
            ->where('class_id', $id)
            ->orderByDesc('id')
            ->paginate(10);
        return view('admin.studentbyclass.index', compact('class', 'classStudent'));
    }

    public function showModalAddStudent(Request $request)
    {
        if ($request->ajax()){
            $classId = $request->classId;

            //check student already exists in class
            $classStudent = ClassStudent::select('student_id')
                ->where('class_id', $classId)
                ->get()
                ->toArray();
            $studentIds = array_map('current', $classStudent);
            $students = Student::where('status','1')->get();

            //check student same shift
            $schedules = Schedule::where('class_id', $classId)
                ->select('weekday_id', 'shift_id')
                ->get()->toArray();
            $schedules = array_unique($schedules, SORT_REGULAR);

            $classStudent2 = ClassStudent::select('class_id')->get()->unique('class_id')->toArray();
            $classIds = array_map('current', $classStudent2);

            $schedules2 = Schedule::whereIn('class_id', $classIds)
                ->select('weekday_id', 'shift_id', 'class_id')
                ->get()->toArray();
            $schedules2 = array_unique($schedules2, SORT_REGULAR);

            $classSameShift = [];

            foreach ($schedules as $schedule) {
                foreach ($schedules2 as $schedule2) {
                    if($schedule2['weekday_id'] == $schedule['weekday_id'] && $schedule2['shift_id'] == $schedule['shift_id']) {
                        array_push($classSameShift, $schedule2['class_id']);
                    }
                }
            }

            $classSameShift = array_unique($classSameShift, SORT_REGULAR);

            $studentSameShift = ClassStudent::select('student_id')->whereIn('class_id', $classSameShift)->get()->toArray();

            $studentSameShift = array_map('current', $studentSameShift);

            $viewData = [
                'students' => $students,
                'studentIds' => $studentIds,
                'studentSameShift' => $studentSameShift,
                'classId' => $classId
            ];

            $html = view('admin.component.ajax.studentbyclass.modal-add-student', $viewData)->render();
            return response()->json(['html' => $html]);
        }
    }

    public function saveStudentByClass(Request $request)
    {
        if($request->ajax()) {
            if($request->students) {
                $studentIds = $request->students;
                $classId = $request->classId;
                foreach ($studentIds as $studentId) {
                    $classStudent = new ClassStudent();
                    $classStudent->class_id = $classId;
                    $classStudent->student_id = $studentId;
                    $classStudent->save();
                }

                Session::put('success', 'Thêm học sinh vào lớp thành công !');
                return response()->json(['success' => true]);
            }
        }
    }

    public function showModalChangeStudent(Request $request)
    {
        if($request->ajax()) {
            $studentId = $request->studentId;
            $classId = $request->classId;

            // get date time current
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $date = date("Y-m-d");
            $time = date('H:i:s');
            // get student by id
            $student = Student::select('full_name','code')->find($studentId);

            // get class by id
            $class = ClassModel::with('course:id,name')
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

            $classStudent = ClassStudent::select('class_id')
                ->where('student_id', $studentId)
                ->get()->toArray();

            $classIds =  \Arr::flatten($classStudent);

            $classes = ClassModel::whereNotIn('id', $classIds)
                ->where('end_date', '!=', null)
                ->where('status', 1)
                ->get()->toArray();

            foreach ($classes as $key1 => $class1) {
                $numberLearnedClassSelectArr = null;
                $numberLearnedClassSelect = null;
                $numberLearnedClassSelectArr = Schedule::with('shift:id,name,start_at,end_at')
                    ->where('class_id', $class1['id'])
                    ->where('date', '<=',$date)
                    ->get();

                $numberLearnedClassSelect = $numberLearnedClassSelectArr->count();

                foreach ($numberLearnedClassSelectArr->toArray() as $numLearClassSelect) {
                    if ($numLearClassSelect['shift']['end_at'] > $time && $date == $numLearClassSelect['date']) {
                        $numberLearnedClassSelect = $numberLearnedClassSelect - 1;
                    }
                }
                $classes[$key1]['numberLearned'] = $numberLearnedClassSelect;
            }

            $numberLearnedArr = Schedule::with('shift:id,name,start_at,end_at')
                ->where('class_id', $classId)
                ->where('date', '<=',$date)
                ->get();

            $numberLearned = $numberLearnedArr->count();

            foreach ($numberLearnedArr->toArray() as $numLear) {
                if ($numLear['shift']['end_at'] > $time && $date == $numLear['date']) {
                    $numberLearned = $numberLearned - 1;
                }
            }

            $html = view('admin.component.ajax.studentbyclass.modal-change-student', compact('class', 'scheduleArr', 'classes', 'studentId', 'numberLearned'))->render();
            return response()->json(['html' => $html, 'student' => $student]);
        }
    }

    public function checkSelectClass (Request $request)
    {
        if($request->ajax()){
            $classId = $request->classId;
            $classCurrentId = $request->classCurrentId;
            $studentId = $request->studentId;

            $class = ClassModel::with('course:id,name')
                ->find($classId);

            $classStudent = ClassStudent::select('class_id')
                ->where('student_id', $studentId)
                ->where('class_id', '!=', $classCurrentId)
                ->get()->toArray();

            $classIds =  \Arr::flatten($classStudent);

            $checkClass = ClassModel::whereIn('id',$classIds)->get();

            $classIds1 = [];

            foreach ($checkClass as $value) {
                if($value->end_date >= $class->start_date) {
                    array_push($classIds1, $value->id);
                }
            }

            $classStudent1 = ClassStudent::where('class_id', $classId)->get()->count();


            if(count($classIds1) > 0) {
                $schedulesClassSelected = Schedule::select('shift_id', 'room_id', 'weekday_id')
                    ->whereIn('class_id', $classIds1)
                    ->get()->toArray();

                $schedulesClassSelected1 = Schedule::select('shift_id', 'room_id', 'weekday_id')
                    ->where('class_id', $classId)
                    ->get()->toArray();

                $scheduleArr = array_unique($schedulesClassSelected, SORT_REGULAR);
                $scheduleArr1 = array_unique($schedulesClassSelected1, SORT_REGULAR);

                $flag = true;
                foreach ($scheduleArr as $item){
                    foreach ($scheduleArr1 as $item1) {
                        if($item['shift_id'] == $item1['shift_id'] && $item['weekday_id'] == $item1['weekday_id']) {
                            $flag = false;
                            break;
                        }
                    }
                }

                if ($flag == true) {
                    // show time schedule modal by class

                    if ($classStudent1 == $class->population) {
                        return response()->json(['error' => "Vui lòng chọn lớp khác lớp hiện tại không còn chỗ trống"]);
                    }else {
                        $schedules = Schedule::with('shift:id,name,start_at,end_at')
                            ->with('room:id,name')
                            ->with('weekday:id,name')
                            ->where('class_id', $classId)
                            ->select('shift_id', 'room_id','weekday_id')
                            ->orderBy('weekday_id')
                            ->get()->toArray();

                        $schedules = array_unique($schedules, SORT_REGULAR);

                        $html = view('admin.component.ajax.studentbyclass.modal-content-select-class', compact('class', 'schedules'))->render();
                        return response()->json(['html' => $html, 'studentId' => $studentId]);
                    }
                }else{
                    return response()->json(['error' => "Vui lòng chọn lớp khác lớp bị trùng ca học"]);
                }
            }else{
                // show time schedule modal by class
                if ($classStudent1 == $class->population) {
                    return response()->json(['error' => "Vui lòng chọn lớp khác lớp hiện tại không còn chỗ trống"]);
                }else {
                    $schedules = Schedule::with('shift:id,name,start_at,end_at')
                        ->with('room:id,name')
                        ->with('weekday:id,name')
                        ->where('class_id', $classId)
                        ->select('shift_id', 'room_id','weekday_id')
                        ->orderBy('weekday_id')
                        ->get()->toArray();

                    $schedules = array_unique($schedules, SORT_REGULAR);

                    $html = view('admin.component.ajax.studentbyclass.modal-content-select-class', compact('class', 'schedules'))->render();
                    return response()->json(['html' => $html, 'studentId' => $studentId]);
                }
            }

        }
    }

    public function saveChangeStudentByClass(Request $request)
    {
        if ($request->ajax()) {
            $classId = $request->classId;
            $classIdCurrent = $request->classIdCurrent;
            $studentId = $request->studentId;

            if($classId && $classIdCurrent && $studentId) {
                $deleteStudentClassCurrent = ClassStudent::where('class_id', $classIdCurrent)
                    ->where('student_id', $studentId)
                    ->delete();

                if($deleteStudentClassCurrent == 1) {
                    $classStudent = new ClassStudent();
                    $classStudent->class_id = $classId;
                    $classStudent->student_id = $studentId;
                    $classStudent->save();

                    Session::put('success', 'Chuyển học sinh vào lớp thành công !');
                    return response()->json(['success' => true]);
                }
            }
        }
    }

    public function searchStudentByClass(Request $request) {
        if($request->ajax()) {
            $keyword = trim($request->keyword);

            $classId = $request->classId;

            //check student already exists in class
            $classStudent = ClassStudent::select('student_id')
                ->where('class_id', $classId)
                ->get()
                ->toArray();
            $studentIds = array_map('current', $classStudent);
            $students = Student::where('status','1')
                ->where('full_name','like','%'.$keyword.'%')
                ->orWhere('code','like','%'.$keyword.'%')
                ->orWhere('email','like','%'.$keyword.'%')
                ->orWhere('phone','like','%'.$keyword.'%')
                ->get();

            //check student same shift
            $schedules = Schedule::where('class_id', $classId)
                ->select('weekday_id', 'shift_id')
                ->get()->toArray();
            $schedules = array_unique($schedules, SORT_REGULAR);

            $classStudent2 = ClassStudent::select('class_id')->get()->unique('class_id')->toArray();
            $classIds = array_map('current', $classStudent2);

            $schedules2 = Schedule::whereIn('class_id', $classIds)
                ->select('weekday_id', 'shift_id', 'class_id')
                ->get()->toArray();
            $schedules2 = array_unique($schedules2, SORT_REGULAR);

            $classSameShift = [];

            foreach ($schedules as $schedule) {
                foreach ($schedules2 as $schedule2) {
                    if($schedule2['weekday_id'] == $schedule['weekday_id'] && $schedule2['shift_id'] == $schedule['shift_id']) {
                        array_push($classSameShift, $schedule2['class_id']);
                    }
                }
            }

            $classSameShift = array_unique($classSameShift, SORT_REGULAR);

            $studentSameShift = ClassStudent::select('student_id')->whereIn('class_id', $classSameShift)->get()->toArray();

            $studentSameShift = array_map('current', $studentSameShift);

            $viewData = [
                'students' => $students,
                'studentIds' => $studentIds,
                'studentSameShift' => $studentSameShift
            ];

            $html = view('admin.component.ajax.studentbyclass.content-search-list-student', $viewData)->render();
            return response()->json(['html' => $html]);
        }
    }

    public function filterStudentByClass(Request $request) {
        if($request->ajax()) {
            $kw_code = trim($request->kw_code);
            $kw_full_name = trim($request->kw_full_name);
            $kw_email = trim($request->kw_email);
            $kw_phone = trim($request->kw_phone);
            $classId = $request->classId;

            //check student already exists in class
            $classStudent = ClassStudent::select('student_id')
                ->where('class_id', $classId)
                ->get()
                ->toArray();
            $studentIds = array_map('current', $classStudent);

            $students = Student::where('status','1');
            if($kw_code)  $students->where('code','like','%'.$kw_code.'%' );
            if($kw_full_name)  $students->where('full_name','like','%'.$kw_full_name.'%' );
            if($kw_email)  $students->where('email','like','%'.$kw_email.'%' );
            if($kw_phone)  $students->where('phone','like','%'.$kw_phone.'%' );
            $students = $students->get();

            //check student same shift
            $schedules = Schedule::where('class_id', $classId)
                ->select('weekday_id', 'shift_id')
                ->get()->toArray();
            $schedules = array_unique($schedules, SORT_REGULAR);

            $classStudent2 = ClassStudent::select('class_id')->get()->unique('class_id')->toArray();
            $classIds = array_map('current', $classStudent2);

            $schedules2 = Schedule::whereIn('class_id', $classIds)
                ->select('weekday_id', 'shift_id', 'class_id')
                ->get()->toArray();
            $schedules2 = array_unique($schedules2, SORT_REGULAR);

            $classSameShift = [];

            foreach ($schedules as $schedule) {
                foreach ($schedules2 as $schedule2) {
                    if($schedule2['weekday_id'] == $schedule['weekday_id'] && $schedule2['shift_id'] == $schedule['shift_id']) {
                        array_push($classSameShift, $schedule2['class_id']);
                    }
                }
            }

            $classSameShift = array_unique($classSameShift, SORT_REGULAR);

            $studentSameShift = ClassStudent::select('student_id')->whereIn('class_id', $classSameShift)->get()->toArray();

            $studentSameShift = array_map('current', $studentSameShift);

            $viewData = [
                'students' => $students,
                'studentIds' => $studentIds,
                'studentSameShift' => $studentSameShift
            ];

            $html = view('admin.component.ajax.studentbyclass.content-search-list-student', $viewData)->render();
            return response()->json(['html' => $html]);
        }
    }
}

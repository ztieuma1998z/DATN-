<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\ClassStudent;
use App\Models\RollCall;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RollCallController extends Controller
{
    public function index ($idSchedule, $idClass)
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
            $classStudents = ClassStudent::with('student:id,avatar,full_name,code')
                                    ->where('class_id', $class->id)
                                    ->get();

            return view('admin.rollcall.index',compact('class', 'schedule', 'classStudents', 'studentIds'));
        }

        return redirect()->back()->with('error', 'Lớp không tồn tại !');

    }

    public function save(Request $request)
    {
        $scheduleId = $request->schedule_id;
        $classId = $request->class_id;
        $data = $request->except('schedule_id', 'class_id', '_token');
        $studentIs = array_filter($data, 'is_numeric');

        RollCall::where('schedule_id', $scheduleId)
                ->where('class_id', $classId)
                ->delete();

        if (count($studentIs) > 0) {
            foreach ($studentIs as $student) {
                $rollcall = new RollCall();
                $rollcall->schedule_id = $scheduleId;
                $rollcall->class_id = $classId;
                $rollcall->user_id = Auth::user()->id;
                $rollcall->student_id = $student;
                $rollcall->save();
            }
        }

        return redirect()->route('get.class.schedule.index', $classId)->with('success', 'Điểm danh thành công !');
    }
}

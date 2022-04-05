<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Weekday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $kw_name = $request->kw_name;
        $kw_course = $request->kw_course;
        $kw_status = $request->kw_status;

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d");

        $classes = ClassModel::with('schedule:id,class_id')
                            ->with('course:id,name')
                            ->with('classStudent:class_id');

        if(trim($kw_name)){
            $classes->where('name','like','%'.$kw_name.'%' );
        }

        if($kw_course){
            $classes->where('course_id',$kw_course);
        }

        if($kw_status>=0 && $kw_status !=null){
            if($kw_status == 1) $classes->where('end_date','!=', null);
            if($kw_status == 0) $classes->where('end_date','=', null);
        }

        $classes = $classes->orderByDesc('id')
            ->paginate(10);

        $shifts = Shift::all();
        $weekdays = Weekday::all();
        $rooms = Room::all();
        $courses = Course::all();
        return view('admin.schedule.index', compact('classes', 'shifts', 'weekdays', 'rooms', 'courses', 'today'));
    }

    public function store(Request $request)
    {
        $rooms = $request->rooms;
        $shifts = $request->shifts;
        $classId = $request->classId;
        $errorField = [];

        // validate
       foreach ($rooms as $key => $room) {
            if($room !== null) {
                if($shifts[$key] === null) {
                    array_push($errorField,['key' => $key, 'name' => 'shift']);
                }
            }
       }

        foreach ($shifts as $key => $shift) {
            if($shift !== null) {
                if($rooms[$key] === null) {
                    array_push($errorField,['key' => $key, 'name' => 'room']);
                }
            }
        }

        if(empty($errorField)) {
            $data = array_filter($shifts);
            if(count($data) >= 2){
                $class = ClassModel::find($classId);
                $class->teacher_id = null;
                $deleteScheduleByClassId = Schedule::where('class_id', $classId)->delete();
                $start_date = $class->start_date;
                $number_of_sessions = $class->number_of_sessions;
                $course_id = $class->course_id;
                $i = 1;
                while ($i <= $number_of_sessions) {
                    $day = date('l', strtotime($start_date));
                    $days = ['Sunday' => "Chủ nhật",
                            'Monday' => "Thứ 2",
                            'Tuesday' => "Thứ 3",
                            'Wednesday' => "Thứ 4",
                            'Thursday' => "Thứ 5",
                            'Friday' => "Thứ 6",
                            'Saturday' => "Thứ 7"];

                    foreach ($data as $key => $value) {
                        // find end_date and save end_date classes
                        $weekday = Weekday::find($key+1);
                        if(strtolower($weekday->name) == strtolower($days[$day]) ) {
                            if ($i == $number_of_sessions) {
                                $end_date = $start_date;
                                $class->end_date = $end_date;
                                $class->save();
                            }
                        // Save schedules
                            $schedule = new Schedule();
                            $schedule->date = $start_date;
                            $schedule->course_id = $course_id;
                            $schedule->shift_id = $value;
                            $schedule->weekday_id = $key+1;
                            $schedule->class_id = $classId;
                            $schedule->room_id = $rooms[$key];
                            $schedule->save();

                            $i++;
                        }
                    }
                    $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
                }

                Session::put('success', 'Xếp lịch học thành công !');
                return response()->json(['success' => true]);
            }else{
                return response()->json([ 'error' => 'Lịch học phải ít nhất 2 ca trong 1 tuần !']);
            }
        }else{
            return response()->json([ 'errorField' => $errorField]);
        }
    }

    public function getAjaxClass(Request $request)
    {
        if($request->id) {
            $classId = $request->id;
            $class = ClassModel::with('course:id,name')->find($classId);
            $shifts = Shift::all();
            $weekdays = Weekday::all();
            $rooms = Room::all();

            $checkClass = ClassModel::select('id')
                                    ->Where('end_date', '>=', $class->start_date)
                                    ->get();
            $classIds = [];
            foreach ($checkClass as $value) {
                array_push ( $classIds,$value->id);
            }

            $schedules = Schedule::select('weekday_id', 'room_id', 'shift_id')
                                ->whereIn('class_id', $classIds)
                                ->orderBy('weekday_id')
                                ->get();

            $scheduleArr = json_decode(json_encode($schedules), true);
            $scheduleArr = array_unique($scheduleArr, SORT_REGULAR);


            // check while schedule when open modal
            $ShiftRoom = $shifts->count() * $rooms->count();

            $array1 = array_map(function($element){
                return $element['weekday_id'];
            }, $scheduleArr);

            $array2 = (array_count_values($array1));

            $sameSchedule = [];

            foreach ($array2 as $key => $value) {
                if($value == $ShiftRoom) {
                    array_push($sameSchedule, $key);
                }
            }

            // check room when open modal
            $weekdayArr = array_keys($array2);

            $checkRooms = [];
            $checkWeekdays = [];

            for ($i=0; $i<count($weekdayArr) ; $i++) {
                $arr = [];
                foreach ($scheduleArr as $schedule) {
                    if($schedule['weekday_id'] == $weekdayArr[$i]) {
                        array_push($arr,$schedule['room_id']);
                    }
                }
                $countValueRoom = array_count_values($arr);

                foreach ($countValueRoom as $key => $item) {
                    if ($item == $shifts->count()) {
                        array_push($checkWeekdays, $weekdayArr[$i]);

                        array_push($checkRooms,
                            [
                                'weekday_id' => $weekdayArr[$i],
                                'room_id' => $key
                            ]);

                    }
                }
            }

            $weekdays = $weekdays->toArray();
            $rooms = $rooms->toArray();
            foreach ($weekdays as $keyWD => $weekday) {
                $weekdays[$keyWD]['rooms'] = $rooms;
            }

            foreach ($weekdays as $keyWD => $weekday) {
                foreach ($weekday['rooms'] as $keyWR => $room) {
                    foreach ($checkRooms as $checkRoom) {
                        if ($checkRoom['room_id'] == $room['id'] && $checkRoom['weekday_id'] == $weekday['id']) {
                            $weekdays[$keyWD]['rooms'][$keyWR]['check_room'] = true ;
                        }
                    }
                }
            }

            $viewData = [
                'sameSchedule' => $sameSchedule,
                'checkRooms' => $checkRooms,
                'checkWeekdays' => $checkWeekdays,
                'shifts' => $shifts,
                'weekdays' => $weekdays,
                'rooms' => $rooms,
                'class' => $class
            ];

            $html = view('admin.component.ajax.render.schedule', $viewData)->render();
            return response()->json([ 'class' => $class, 'html' => $html]);
        }
    }

    public function getScheduleView(Request $request)
    {
        if($request->id) {
            $classId = $request->id;
            $class = ClassModel::find($classId);

            $schedules = Schedule::with('course:id,name')
                                ->with('teacher:id,full_name')
                                ->with('class:id,name')
                                ->with('shift:id,name,start_at,end_at')
                                ->with('room:id,name')
                                ->with('weekday:id,name')
                                ->where('class_id', $classId)
                                ->orderBy('date')
                                ->orderBy('shift_id')
                                ->get();
            $html = view('admin.component.ajax.render.schedule-view', compact('schedules'))->render();
            return response()->json([ 'class' => $class, 'html' => $html]);
        }
    }

    public function checkShiftByRoom(Request $request)
    {
        if($request->id && $request->classId && $request->weekdayId) {
            $roomId = $request->id;
            $classId = $request->classId;
            $weekdayId = $request->weekdayId;
            $class = ClassModel::find($classId);
            $checkClass = ClassModel::select('id')
                ->Where('end_date', '>=', $class->start_date)
                ->get();

            $scheduleClassCurrent = Schedule::select('weekday_id', 'room_id', 'shift_id')
                ->where('class_id', $classId)
                ->where('weekday_id', $weekdayId)
                ->where('room_id', $roomId)
                ->get()->toArray();
            $scheduleClassCurrent = array_unique($scheduleClassCurrent, SORT_REGULAR);

            $listShift = Shift::all();
            $shiftArr = [];
            foreach ($scheduleClassCurrent as $schClaCur) {
                foreach ($listShift as $lisShi) {
                    if($lisShi->id == $schClaCur['shift_id']) {
                        array_push($shiftArr, $lisShi->id);
                    }
                }
            }

            $classIds = [];
            foreach ($checkClass as $value) {
                array_push ($classIds,$value->id);
            }

            $schedules = Schedule::select('shift_id')
                ->where('room_id', $roomId)
                ->where('weekday_id', $weekdayId)
                ->whereIn('class_id', $classIds)
                ->orderBy('weekday_id')
                ->get();

            $scheduleArr = json_decode(json_encode($schedules), true);
            $scheduleArr = array_unique($scheduleArr, SORT_REGULAR);

            $shifts = Shift::all()->toArray();

            foreach ($shifts as $key => $shift) {
                foreach ($scheduleArr as $schedule) {
                    if ($shift['id'] == $schedule['shift_id']) {
                        $shifts[$key]['check_shift'] = true;
                    }
                }
            }

            $html = view('admin.component.ajax.render.check-shift-by-room', compact( 'shifts', 'weekdayId', 'shiftArr'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function showModalChangeSchedule(Request $request)
    {
        if ($request->id) {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $date_today = date("Y-m-d");
            $classId = $request->id;
            $class = ClassModel::find($classId);
            $schedules = Schedule::with('shift:id,name,start_at,end_at')
                                ->with('weekday:id,name')
                                ->where('class_id', $classId)
                                ->where('date', '>', $date_today)
                                ->orderBy('date')
                                ->get();

            $html = view('admin.component.ajax.render.list-schedule-by-class', compact('schedules'))->render();
            return response()->json(['class' => $class, 'html' => $html]);
        }
    }

    public function changeScheduleByDateTo(Request $request)
    {
        if($request->ajax()) {
            $dateTo = $request->dateTo;
            $html = '';
            $schedules = Schedule::select('room_id', 'shift_id')->where('date',$dateTo)->get()->toArray();

            if (count($schedules) > 0) {
                $shifts = Shift::all()->count();
                $rooms = Room::all()->count();
                $shiftRoom = $shifts*$rooms;

                $roomIds = [];

                foreach ($schedules as $schedule) {
                    array_push($roomIds, $schedule['room_id']);
                }
                $countValueRoom = array_count_values($roomIds);
                $totalShift = array_sum($countValueRoom);

                if($totalShift == $shiftRoom) {
                    $scheduleSameAll = true;
                    $html = view('admin.component.ajax.render.change-schedule-by-date-to', compact('scheduleSameAll'))->render();
                }else{
                    $isCheckRoom = true;
                    $rooms = Room::all();
                    $shifts = Shift::all();
                    $checkRoom = [];
                    foreach ($countValueRoom as $key => $room) {
                        if ($room == $shifts->count()) {
                            array_push($checkRoom, $key);
                        }
                    }
                    $html = view('admin.component.ajax.render.change-schedule-by-date-to', compact('rooms','shifts', 'checkRoom', 'isCheckRoom', 'dateTo'))->render();
                }


            }else{
                $notScheduleSameAll = true;
                $rooms = Room::all();
                $shifts = Shift::all();
                $html = view('admin.component.ajax.render.change-schedule-by-date-to', compact('notScheduleSameAll','rooms', 'shifts','dateTo'))->render();
            }

            return response()->json(['html' => $html]);
        }
    }

    public function changeScheduleCheckShiftByRoom (Request $request)
    {
        if($request->ajax()) {
            $roomId = $request->roomId;
            $classId = $request->classId;
            $dateTo = $request->dateTo;
            $shifts = Shift::all();
            $schedules = Schedule::select('shift_id')
                                    ->where('date',$dateTo)
                                    ->where('room_id', $roomId)
                                    ->get()
                                    ->toArray();
            $checkShift = [];

            foreach ($schedules as $schedule) {
                array_push($checkShift, $schedule['shift_id']);
            }

            $html = view('admin.component.ajax.render.change-schedule-check-shift-by-room', compact('checkShift', 'shifts'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function saveChangeSchedule(Request $request)
    {
        if($request->ajax()) {
            $scheduleId = $request->date_from;
            $date_to = $request->date_to;
            $roomId = $request->room;
            $shiftId = $request->shift;
            $classId = $request->classId;

            $class  = ClassModel::where('teacher_id', '!=', null)->find($classId);

           if(!empty($class)) {
               $scheduleByTeacher = Schedule::with('shift:id,name,start_at,end_at')
                   ->with('room:id,name')
                   ->with('weekday:id,name')
                   ->with('teacher:id,full_name')
                   ->where('teacher_id', $class->teacher_id)
                   ->where('date', $date_to)
                   ->where('shift_id', $shiftId)
                   ->get()->toArray();

                if(!empty($scheduleByTeacher)){
                    return response()->json(['errorSameSchedule' => "Trùng lịch dạy của giáo viên vui lòng chọn ca khác !"]);
                }
           }

            try {
                // get weekday
                $weekday = date('l', strtotime($date_to));
                $days = ['Sunday' => "Chủ nhật",
                    'Monday' => "Thứ 2",
                    'Tuesday' => "Thứ 3",
                    'Wednesday' => "Thứ 4",
                    'Thursday' => "Thứ 5",
                    'Friday' => "Thứ 6",
                    'Saturday' => "Thứ 7"];

                $weekday1 = '';

                foreach ($days as $key => $day) {
                    if ($weekday == $key) {
                        $weekday1 = $days[$key];
                        break;
                    }
                }

                $weekday = Weekday::where('name', $weekday1)->get()->toArray();

                // update schedule
                $schedule = Schedule::find($scheduleId);
                $schedule->date = $date_to;
                $schedule->room_id = $roomId;
                $schedule->shift_id = $shiftId;
                $schedule->weekday_id = $weekday[0]['id'];
                $schedule->save();

                $class = ClassModel::where('end_date', '<', $date_to)->find($classId);
                if ($class) {
                    // update end_date by class
                    $class->end_date = $date_to;
                    $class->save();
                }

                Session::put('success', 'Chuyển lịch học thành công !');
                return response()->json(['success' => true]);
            } catch (\Exception $exception) {
                Session::put('error', 'Chuyển lịch học thất bại !');
                return response()->json(['error' => true]);
            }
        }
    }

    public function showModalEditSchedule(Request $request)
    {
        if($request->id) {
            $classId = $request->id;
            $class = ClassModel::with('course:id,name')->find($classId);
            $shifts = Shift::all();
            $weekdays = Weekday::all();
            $rooms = Room::all();

            $scheduleClassCurrent = Schedule::with('shift:id,name,start_at,end_at')
                                            ->select('weekday_id', 'room_id', 'shift_id')
                                            ->where('class_id', $classId)
                                            ->get()->toArray();
            $scheduleClassCurrent = array_unique($scheduleClassCurrent, SORT_REGULAR);

            $checkClass = ClassModel::select('id')
                ->Where('end_date', '>=', $class->start_date)
                ->get();
            $classIds = [];
            foreach ($checkClass as $value) {
                array_push ( $classIds,$value->id);
            }

            $schedules = Schedule::select('weekday_id', 'room_id', 'shift_id')
                ->whereIn('class_id', $classIds)
                ->orderBy('weekday_id')
                ->get();

            $scheduleArr = json_decode(json_encode($schedules), true);
            $scheduleArr = array_unique($scheduleArr, SORT_REGULAR);


            // check while schedule when open modal
            $ShiftRoom = $shifts->count() * $rooms->count();

            $array1 = array_map(function($element){
                return $element['weekday_id'];
            }, $scheduleArr);

            $array2 = (array_count_values($array1));

            $sameSchedule = [];

            foreach ($array2 as $key => $value) {
                if($value == $ShiftRoom) {
                    array_push($sameSchedule, $key);
                }
            }

            // check room when open modal
            $weekdayArr = array_keys($array2);

            $checkRooms = [];
            $checkWeekdays = [];

            for ($i=0; $i<count($weekdayArr) ; $i++) {
                $arr = [];
                foreach ($scheduleArr as $schedule) {
                    if($schedule['weekday_id'] == $weekdayArr[$i]) {
                        array_push($arr,$schedule['room_id']);
                    }
                }
                $countValueRoom = array_count_values($arr);

                foreach ($countValueRoom as $key => $item) {
                    if ($item == $shifts->count()) {
                        array_push($checkWeekdays, $weekdayArr[$i]);

                        array_push($checkRooms,
                            [
                                'weekday_id' => $weekdayArr[$i],
                                'room_id' => $key
                            ]);

                    }
                }
            }

            // check shift same when open modal

            $checkShiftArr = [];

            foreach ($scheduleClassCurrent as $itemSchClaCur) {
                $scheduleCheckSameShift = Schedule::select('shift_id', 'weekday_id')
                    ->where('room_id', $itemSchClaCur['room_id'])
                    ->where('weekday_id', $itemSchClaCur['weekday_id'])
                    ->whereIn('class_id', $classIds)
                    ->where('class_id', '!=', $classId)
                    ->orderBy('weekday_id')
                    ->get()->toArray();

                $scheduleCheckSameShift = array_unique($scheduleCheckSameShift, SORT_REGULAR);

                $shiftIds = [];
                foreach ($scheduleCheckSameShift as $itemSchClaCur1) {
                    array_push($shiftIds,$itemSchClaCur1['shift_id']);
                }

                array_push($checkShiftArr, [
                    'weekday_id' => $itemSchClaCur['weekday_id'],
                    'shift_ids'  => $shiftIds
                ]);
            }

            $weekdays = $weekdays->toArray();
            $rooms = $rooms->toArray();
            foreach ($weekdays as $keyWD => $weekday) {
                $weekdays[$keyWD]['rooms'] = $rooms;
            }

            foreach ($weekdays as $keyWD => $weekday) {
                foreach ($weekday['rooms'] as $keyWR => $room) {
                    foreach ($checkRooms as $checkRoom) {
                        if ($checkRoom['room_id'] == $room['id'] && $checkRoom['weekday_id'] == $weekday['id']) {
                            $weekdays[$keyWD]['rooms'][$keyWR]['check_room'] = true ;
                        }
                    }
                }
            }

            $viewData = [
                'sameSchedule' => $sameSchedule,
                'checkRooms' => $checkRooms,
                'checkWeekdays' => $checkWeekdays,
                'shifts' => $shifts,
                'weekdays' => $weekdays,
                'rooms' => $rooms,
                'class' => $class,
                'scheduleClassCurrent' => $scheduleClassCurrent,
                'checkShiftArr' => $checkShiftArr
            ];

            $html = view('admin.component.ajax.render.edit-schedule', $viewData)->render();
            return response()->json([ 'class' => $class, 'html' => $html]);
        }
    }
}

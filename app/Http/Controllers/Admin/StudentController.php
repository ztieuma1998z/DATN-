<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestStudent;
use App\Mail\Auth\VerifyAccount;
use App\Models\ClassStudent;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $kw_code = trim($request->kw_code);
        $kw_full_name = trim($request->kw_full_name);
        $kw_status = $request->kw_status;
        $kw_gender = $request->kw_gender;
        $kw_phone = $request->kw_phone;
        $kw_email = $request->kw_email;


        $students = Student::query();
        if($kw_code) $students->where('code','like','%'.$kw_code.'%' );
        if($kw_full_name) $students->where('full_name','like','%'.$kw_full_name.'%' );
        if($kw_phone) $students->where('phone','like','%'.$kw_phone.'%' );
        if($kw_email) $students->where('email','like','%'.$kw_email.'%' );
        if($kw_status>=0 && $kw_status !=null){
            $students->where('status',$kw_status);
        }

        if($kw_gender>=0 && $kw_gender !=null){
            $students->where('gender',$kw_gender);
        }

        $students = $students->orderByDesc('id')
            ->paginate(10);

        return view('admin.student.index', [
            'students' => $students,
        ]);
    }

    public function create()
    {
        return view('admin.student.add_edit');
    }

    public function store(RequestStudent $request)
    {
        $student = Student::select('code')->orderBy('id', 'desc')->first();
        $res = preg_replace("/[^a-zA-Z]/", "", $student->code);
        $code = ltrim($student->code, $res);
        $code = 'PH'.sprintf('%03d',$code+1);

        $random_password = Str::random(16);
        $student = new Student();

        $student->code = $code;
        $student->gender = $request->gender;
        $student->address = $request->address;
        $student->full_name = $request->full_name;
        $student->email = $request->email;
        $student->password = bcrypt($random_password);
        $student->phone = $request->phone;
        $student->birth_date = $request->birth_date;
        $request->has('status') ? $student->status = 1 : $student->status = 0;

        //Handle avatar request
        if ($request->hasFile('avatar')) {
            $extension = $request->avatar->extension();
            $filename = 'students-' . uniqid() . '.' . $extension;
            $student->avatar = $request->avatar->storeAs('students', $filename, 'public');
        }

        $student->save();

        Mail::to($request->email)
            ->send(new VerifyAccount(
                    $request->full_name,
                    $request->email,
                    $random_password
                )
            );
        return redirect()->route('get.student.index')->with('success', 'Thêm mới học sinh thành công !');
    }

    public function edit($id)
    {
        $student = Student::query()->findOrFail($id);

        return view('admin.student.add_edit', [
            'student' => $student,
        ]);
    }

    public function update(RequestStudent $request, $id)
    {
        if ($id) {
            $student = Student::find($id);
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->full_name = $request->full_name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->birth_date = $request->birth_date;
            $request->has('status') ? $student->status = 1 : $student->status = 0;

            //Handle avatar request
            if ($request->hasFile('avatar')) {
                $extension = $request->avatar->extension();
                $filename = 'students-' . uniqid() . '.' . $extension;
                $student->avatar = $request->avatar->storeAs('students', $filename, 'public');
            }
            $student->save();

            return redirect()->route('get.student.index')->with('success', 'Cập nhật học sinh thành công !');
        }
    }

    public function action($action, $id)
    {
        if ($action) {
            $student = Student::find($id);
            if (empty($student)) {
                return redirect()->back()->with('error', 'Học sinh không tồn tại !');
            }
            switch ($action) {
                case 'delete':
                    $student->delete();
                    return redirect()->back()->with('success', 'Xóa tài khoản học sinh thành công !');
                case 'status':
                    $student->status = $student->status ? 0 : 1;
                    $student->save();
                    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công !');
            }
        }
    }

    public function showInformationStudent (Request $request)
    {
        if($request->ajax()) {
            $studentId = $request->studentId;
            $student = Student::find($studentId);

            $class_student = ClassStudent::select('class_id')
                            ->where('student_id', $studentId)
                            ->get()->unique('class_id');
            $classIds = [];

            foreach ($class_student as $item) {
                array_push($classIds, $item->class_id);
            }

            $classes = DB::table('classes')
                ->whereIn('classes.id',$classIds)
                ->join('courses', 'courses.id', '=', 'classes.course_id')
                ->select('classes.*', 'courses.name as course_name')
                ->get();

            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $today = date("Y-m-d");

            $viewData = [
              'student' => $student,
              'classes' => $classes,
               'today' =>  $today,
            ];

            $html = view('admin.component.ajax.information-student', $viewData)->render();
            return response()->json(['html' => $html]);
        }
    }
}

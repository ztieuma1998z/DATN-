<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestTeacher;
use App\Mail\Auth\VerifyAccount;
use App\Models\ClassModel;
use App\Models\Specialized;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $kw_code = trim($request->kw_code);
        $kw_full_name = trim($request->kw_full_name);
        $kw_status = $request->kw_status;
        $kw_gender = $request->kw_gender;
        $kw_phone = $request->kw_phone;
        $kw_email = $request->kw_email;
        $kw_specialized = $request->kw_specialized;

        $teachers = Teacher::with('specialized:id,name');

        $specializeds = Specialized::all();

        if($kw_code) $teachers->where('code','like','%'.$kw_code.'%' );
        if($kw_full_name) $teachers->where('full_name','like','%'.$kw_full_name.'%' );
        if($kw_phone) $teachers->where('phone','like','%'.$kw_phone.'%' );
        if($kw_email) $teachers->where('email','like','%'.$kw_email.'%' );

        if ($kw_specialized) {
            $teachers->where('specialized_id', $kw_specialized);
        }

        if($kw_status>=0 && $kw_status !=null){
            $teachers->where('status',$kw_status);
        }

        if($kw_gender>=0 && $kw_gender !=null){
            $teachers->where('gender',$kw_gender);
        }

        $teachers = $teachers->orderByDesc('id')
            ->paginate(10);

        return view('admin.teacher.index', compact('teachers', 'specializeds'));
    }

    public function create()
    {
        $specializeds = Specialized::all();
        return view('admin.teacher.add_edit', compact('specializeds'));
    }

    public function store(RequestTeacher $request)
    {
        try {
            $this->insertOrUpdate($request);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('get.teacher.index')->with('success', 'Thêm mới giáo viên thành công !');
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        $specializeds = Specialized::all();
        if (empty($teacher)) {
            return redirect()->back()->with('error', 'Giáo viên không tồn tại !');
        }
        return view('admin.teacher.add_edit', compact('teacher', 'specializeds'));
    }

    public function update(RequestTeacher $request, $id)
    {
        try {
            $this->insertOrUpdate($request, $id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('get.teacher.index')->with('success', 'Cập nhật giáo viên thành công !');
    }

    public function insertOrUpdate($request, $id = null)
    {
        $teacher = new Teacher();
        if ($id) {
            $teacher = Teacher::find($id);
            if (empty($teacher)) return redirect()->back()->with('error', 'Giáo viên không tồn tại !');
        }
        $teacher->full_name = $request->full_name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->address = $request->address;
        $teacher->specialized_id = $request->specialized_id;
        $teacher->birth_date = $request->birth_date;
        $teacher->gender = $request->gender;
        $request->has('status') ? $teacher->status = 1 : $teacher->status = 0;
        if ($request->hasFile('avatar')) {
            $extension = $request->avatar->extension();
            $filename = 'teachers-' . uniqid() . '.' . $extension;
            $teacher->avatar = $request->avatar->storeAs('teachers', $filename, 'public');
        }

        if (!$id) {
            $random_password = Str::random(16);
            $teacher->password = bcrypt($random_password);

            $teacherLast = Teacher::select('code')->orderBy('id', 'desc')->first();
            $res = preg_replace("/[^a-zA-Z]/", "", $teacherLast->code);
            $code = ltrim($teacherLast->code, $res);
            $code = 'GV'.sprintf('%03d',$code+1);
            $teacher->code = $code;
        }else {
            $teacher->code = $request->code;
        }

        $teacher->save();

        if (!$id) {
            Mail::to($request->email)
                ->send(new VerifyAccount(
                        $request->full_name,
                        $request->email,
                        $random_password
                    )
                );
        }
    }

    public function action($action, $id)
    {
        if ($action) {
            $teacher = Teacher::find($id);
            if (empty($teacher)) {
                return redirect()->back()->with('error', 'Giáo viên không tồn tại !');
            }
            switch ($action) {
                case 'delete':
                    $teacher->delete();
                    return redirect()->back()->with('success', 'Xóa tài khoản giáo viên thành công !');
                case 'status':
                    $teacher->status = $teacher->status ? 0 : 1;
                    $teacher->save();
                    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công !');
            }
        }
    }

    public function showInformationTeacher(Request $request)
    {
        if ($request->ajax()){
            $teacherId = $request->teacherId;
            $teacher = Teacher::find($teacherId);

            $classes = ClassModel::with('course:id,name')
                                ->where('teacher_id', $teacherId)
                                ->get();

            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $today = date("Y-m-d");

            $viewData = [
                'teacher' => $teacher,
                'today' => $today,
                'classes' => $classes
            ];

            $html = view('admin.component.ajax.information-teacher', $viewData)->render();
            return response()->json(['html' => $html]);
        }
    }
}

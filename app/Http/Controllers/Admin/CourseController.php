<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCourse;
use App\Models\ClassModel;
use App\Models\Course;
use App\Models\Specialized;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index (Request $request)
    {
        $kw_name = $request->kw_name;
        $kw_specialized = $request->kw_specialized;
        $kw_price_from = $request->kw_price_from;
        $kw_price_to = $request->kw_price_to;

        $courses = Course::with('specialized:id,name');

        if (trim($kw_name)) {
            $courses->where('name', 'like', '%' . $kw_name . '%');
        }

        if ($kw_specialized) {
            $courses->where('specialized_id', $kw_specialized);
        }

        if ($kw_price_from) {
            $courses->where('price', '>=', $kw_price_from);
        }

        if ($kw_price_to) {
            $courses->where('price', '<=', $kw_price_to);
        }

        $courses = $courses->orderByDesc('id')
            ->paginate(10);

        $specializeds = Specialized::all();
        return view('admin.course.index', compact('courses', 'specializeds'));
    }

    public function create ()
    {
        $specializeds = Specialized::all();
        return view('admin.course.add_edit', compact('specializeds'));
    }

    public function store (RequestCourse $request)
    {
        try {
            $this->insertOrUpdate($request);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('get.course.index')->with('success', 'Tạo mới môn học thành công !');
    }

    public function edit ($id)
    {
        $course = Course::find($id);

        $classes = ClassModel::where('course_id', $id)->get();
        $specializeds = Specialized::all();
        if(empty($course))
        {
            return redirect()->back()->with('error', 'Môn học không tồn tại !');
        }
        return view('admin.course.add_edit', compact('course', 'classes', 'specializeds'));
    }

    public function update(RequestCourse $request, $id)
    {
        try {
            $this->insertOrUpdate($request, $id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('get.course.index')->with('success', 'Cập nhật môn học thành công !');
    }

    public function insertOrUpdate($request, $id = '')
    {
        $course = new Course();
        if($id)
        {
            $course = Course::find($id);
            if(empty($course)) return redirect()->back()->with('error', 'Môn học không tồn tại !');
        }

        $course->name = $request->name;
        $course->description = $request->description;
        $course->content = $request->content;
        $course->price = $request->price;
        $course->number_of_sessions = $request->number_of_sessions;
        $course->specialized_id = $request->specialized_id;


        if($request->hasFile('thumbnail'))
        {
            $extension = $request->thumbnail->extension();
            $filename = 'courses-' . uniqid() . '.' . $extension;
            $course->thumbnail =  $request->thumbnail->storeAs('courses', $filename, 'public');
        }
        $course->save();
    }

//    public function delete ($id)
//    {
//        $course = Course::find($id);
//
//        $course->delete();
//        return redirect()->back()->with('success', 'Xóa môn học thành công !');
//    }
}

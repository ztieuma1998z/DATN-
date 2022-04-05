<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends FrontendController
{
    public function index()
    {
        $courses = Course::all();
        return view('frontend.course.index', compact('courses'));
    }

    public function detail($id)
    {
        $course = Course::find($id);
        $courseRelated = Course::where('id','!=',$id)->paginate(4);
        return view('frontend.coursedetail.index', compact('course', 'courseRelated'));
    }

}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Course;
use Illuminate\Http\Request;
use MongoDB\Driver\Session;

class BlogController extends FrontendController
{
    public function index()
    {
        $blogs = Blog::with('admin:id,full_name')
                        ->where('status','=', 1)
                        ->paginate(5);
        $courses = Course::paginate(5);
        return view('frontend.blog.index', compact('blogs', 'courses'));
    }

    public function detail(Request $request)
    {
        $url = $request->segments()['1'];
        $arrayUrl = preg_split('/(-)/i', $url);
        if($id = array_pop($arrayUrl))
        {
            $blog = Blog::with('admin:id,full_name')->where('status',1)->find($id);
            $blog->view = $blog->view+1;
            $blog->save();
            return view('frontend.blogdetail.index', compact('blog'));
        }
        return redirect()->back();
    }
}

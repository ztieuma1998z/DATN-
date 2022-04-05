<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    public function index()
    {
        $newBlog = Blog::orderByDesc('created_at')->where('status', '1')->paginate(4);
        return view('frontend.homepage.index', compact('newBlog'));
    }
}

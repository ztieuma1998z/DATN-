<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class FrontendController extends Controller
{
    public function __construct()
    {
        $courses = Course::all();
        $setting = Setting::first();
        View::share(['courses' => $courses, 'setting' => $setting]);
    }
}

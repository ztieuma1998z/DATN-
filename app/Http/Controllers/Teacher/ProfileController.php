<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $teacherId = \Auth::user()->id;
        $teacher = Teacher::find($teacherId);
        return view('teacher.profile.index', compact("teacher"));
    }
}

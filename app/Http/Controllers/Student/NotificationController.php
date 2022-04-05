<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $categories = Category::with(['notifications'])->where('status',1)->get();
        return view('student.notification.index', compact('categories'));
    }

    public function detail($id)
    {
        $notification = Notification::where('status', 1)->find($id);
        return view('student.notification.detail', compact('notification'));
    }
}

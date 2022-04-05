<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\ClassModel;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = getdate();
        $currentDate = Carbon::now()->format('Y-m-d');
        $notifications = Notification::with('admin:id,full_name')
                                     ->with('category:id,name')
                                     ->where('created_at','>=',$currentDate. " 00:00:00")
                                     ->get();
        $customers = Customer::with('admin:id,full_name')
                                ->with('course:id,name')
                                ->orderByDesc('created_at')
                                ->paginate(5);

        $students = Student::all();
        $customers1 = Customer::all();
        $classes = ClassModel::all();
        $blogs = Blog::all();

        $viewData = [
            'today' => $today,
            'notifications' => $notifications,
            'customers' => $customers,
            'customers1' => $customers1,
            'students' => $students,
            'classes' => $classes,
            'blogs' => $blogs
        ];

        return view('admin.dashboard.index', $viewData);
    }
}

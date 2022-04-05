<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestNotification;
use App\Jobs\SendNotify;
use App\Jobs\SendNotifySmall;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $kw_title = $request->kw_title;
        $kw_category = $request->kw_category;
        $kw_status = $request->kw_status;
        $kw_date_from = $request->kw_date_from;
        $kw_date_to = $request->kw_date_to;

        $notifications = Notification::with('admin:id,full_name')->with('category:id,name');

        if (trim($kw_title)) {
            $notifications->where('title', 'like', '%' . $kw_title . '%');
        }

        if ($kw_category) {
            $notifications->where('category_id', $kw_category);
        }

        if ($kw_status >= 0 && $kw_status != null) {
            $notifications->where('status', $kw_status);
        }

        if ($kw_date_from) {
            $notifications->where('created_at', '>=', $kw_date_from . " 00:00:00");
        }

        if ($kw_date_to) {
            $notifications->where('created_at', '<=', $kw_date_to . " 23:59:59");
        }

        $notifications = $notifications->orderByDesc('id')
            ->paginate(10);

        $categories = Category::all();
        return view('admin.notification.index', compact('notifications', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.notification.add_edit', compact('categories'));
    }

    public function store(RequestNotification $request)
    {
        try {
            $this->insertOrUpdate($request);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('get.notification.index')->with('success', 'Thêm mới thông báo thành công !');
    }

    public function edit($id)
    {
        $notification = Notification::find($id);
        $categories = Category::all();
        if (empty($notification)) {
            return redirect()->back()->with('error', 'Thông báo không tồn tại !');
        }
        return view('admin.notification.add_edit', compact('notification', 'categories'));
    }

    public function update(RequestNotification $request, $id)
    {
        try {
            $this->insertOrUpdate($request, $id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('get.notification.index')->with('success', 'Cập nhật thông báo thành công !');
    }

    public function insertOrUpdate($request, $id = '')
    {
        $notification = new Notification();
        if ($id) {
            $notification = Notification::find($id);
            if (empty($notification)) return redirect()->back()->with('error', 'Thông báo không tồn tại !');
        }

        $notification->title = $request->title;
        $request->has('status') ? $notification->status = 1 : $notification->status = 0;
        $notification->content = $request->content;
        $notification->admin_id = \Auth::user()->id;
        $notification->category_id = $request->category_id;
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        if (!$id) $notification->created_at = date("Y-m-d H:i:s");
        $notification->updated_at = date("Y-m-d H:i:s");

        $notification->save();
        SendNotify::dispatch($notification->title, $notification->content);
    }

    public function action($action, $id)
    {
        if ($action) {
            $notification = Notification::find($id);
            if (empty($notification)) {
                return redirect()->back()->with('error', 'Thông báo không tồn tại !');
            }
            switch ($action) {
                case 'delete':
                    $notification->delete();
                    return redirect()->back()->with('success', 'Xóa thông báo thành công !');
                case 'status':
                    $notification->status = $notification->status ? 0 : 1;
                    $notification->save();
                    return redirect()->back()->with('success', 'Cập nhật thông báo thành công !');
            }
        }
    }
}

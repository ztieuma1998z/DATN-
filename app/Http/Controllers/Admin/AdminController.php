<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAdmin;
use App\Mail\Auth\VerifyAccount;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $kw_full_name = trim($request->kw_full_name);
        $kw_status = $request->kw_status;
        $kw_phone = $request->kw_phone;
        $kw_email = $request->kw_email;

        $admins = Admin::query();

        if($kw_full_name) $admins->where('full_name','like','%'.$kw_full_name.'%' );
        if($kw_phone) $admins->where('phone','like','%'.$kw_phone.'%' );
        if($kw_email) $admins->where('email','like','%'.$kw_email.'%' );
        if($kw_status>=0 && $kw_status !=null){
            $admins->where('status',$kw_status);
        }

        $admins = $admins->orderByDesc('id')
            ->paginate(10);

        return view('admin.admin.index', [
            'admins' => $admins
        ]);

    }

    public function create()
    {
        return view('admin.admin.add_edit');
    }

    public function store(RequestAdmin $request)
    {
        $random_password = Str::random(16);
        $admin = new Admin();

        $admin->full_name = $request->full_name;
        $admin->email = $request->email;
        $admin->password = bcrypt($random_password);
        $admin->phone = $request->phone;
        $request->has('status') ? $admin->status = 1 : $admin->status = 0;

        //Handle avatar request
        if ($request->hasFile('avatar')) {
            $extension = $request->avatar->extension();
            $filename = 'admins-' . uniqid() . '.' . $extension;
            $admin->avatar = $request->avatar->storeAs('admins', $filename, 'public');
        }

        $admin->save();

        Mail::to($request->email)
            ->send(new VerifyAccount(
                    $request->full_name,
                    $request->email,
                    $random_password
                )
            );
        return redirect()->route('get.admin.index')->with('success', 'Thêm mới quản trị viên thành công !');
    }

    public function edit($id)
    {
        $admin = Admin::query()->findOrFail($id);

        return view('admin.admin.add_edit', [
            'admin' => $admin,
        ]);
    }

    public function update(RequestAdmin $request, $id)
    {
        if ($id) {
            $admin = Admin::find($id);
            $admin->full_name = $request->full_name;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $request->has('status') ? $admin->status = 1 : $admin->status = 0;

            //Handle avatar request
            if ($request->hasFile('avatar')) {
                $extension = $request->avatar->extension();
                $filename = 'admins-' . uniqid() . '.' . $extension;
                $admin->avatar = $request->avatar->storeAs('admins', $filename, 'public');
            }
            $admin->save();


            return redirect()->route('get.admin.index')->with('success', 'Cập nhật quản trị viên thành công !');
        }
    }

    public function action($action, $id)
    {
        if ($action) {
            $admin = Admin::find($id);
            if (empty($admin)) {
                return redirect()->back()->with('error', 'Quản trị viên không tồn tại !');
            }
            switch ($action) {
                case 'delete':
                    $admin->delete();
                    return redirect()->back()->with('success', 'Xóa tài khoản quản trị viên thành công !');
                case 'status':
                    $admin->status = $admin->status ? 0 : 1;
                    $admin->save();
                    return redirect()->back()->with('success', 'Cập nhật trạng thái thành công !');
            }
        }
    }
}

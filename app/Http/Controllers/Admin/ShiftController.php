<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestShift;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::all();
        return view('admin.shift.index', compact('shifts'));
    }

    public function create()
    {
        return view('admin.shift.add_edit');
    }

    public function store(RequestShift $request)
    {
        $data  = $request->except('_token');
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Shift::insert($data);

        return redirect()->route('get.shift.index')->with('success', 'Thêm mới ca học thành công !');
    }

    public function edit($id)
    {
        $shift = Shift::find($id);
        if(empty($shift))
        {
            return redirect()->back()->with('error', 'Ca học không tồn tại !');
        }
        return view('admin.shift.add_edit', compact('shift'));
    }

    public function update(RequestShift $request, $id)
    {
        if($id)
        {
            $shift = Shift::find($id);
            if(empty($shift)) return redirect()->back()->with('error', 'Ca học không tồn tại !');
        }

        $data = $request->except("_token");
        $data['updated_at'] = Carbon::now();
        $shift->update($data);
        return redirect()->route('get.shift.index')->with('success', 'Cập nhật ca học thành công !');
    }

//    public function delete($id)
//    {
//        $shift = Shift::find($id);
//
//        $shift->delete();
//        return redirect()->back()->with('success', 'Xóa ca học thành công !');
//    }
}

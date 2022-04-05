<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestRoom;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.room.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.room.add_edit');
    }

    public function store(RequestRoom $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        Room::insert($data);

        return redirect()->route('get.room.index')->with('success', 'Thêm mới phòng thành công !');
    }

    public function edit($id)
    {
        $room = Room::find($id);
        if(empty($room))
        {
            return redirect()->back()->with('error', 'Phòng không tồn tại !');
        }
        return view('admin.room.add_edit', compact('room'));
    }

    public function update(RequestRoom $request, $id)
    {
        if($id)
        {
            $room = Room::find($id);
            if(empty($room)) return redirect()->back()->with('error', 'Phòng không tồn tại !');
        }

        $data = $request->except("_token");
        $data['updated_at'] = Carbon::now();
        $room->update($data);
        return redirect()->route('get.room.index')->with('success', 'Cập nhật phòng thành công !');
    }

//    public function delete ($id)
//    {
//        $room = Room::find($id);
//
//        $room->delete();
//        return redirect()->back()->with('success', 'Xóa phòng học thành công !');
//    }
}

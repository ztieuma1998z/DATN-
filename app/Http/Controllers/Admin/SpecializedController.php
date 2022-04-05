<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestSpecialized;
use App\Models\Specialized;
use Illuminate\Http\Request;

class SpecializedController extends Controller
{
    public function index()
    {
        $specializeds = Specialized::all();
        return view('admin.specialized.index', compact('specializeds'));
    }

    public function create ()
    {
        return view('admin.specialized.add_edit');
    }

    public function store (RequestSpecialized $request)
    {
        $data = $request->except("_token");
        Specialized::insert($data);
        return redirect()->route('get.specialized.index')->with('success', 'Thêm mới chuyên ngành thành công !');
    }

    public function edit ($id)
    {
        $specialized = Specialized::find($id);
        if(empty($specialized))
        {
            return redirect()->back()->with('error', 'Chuyên ngành không tồn tại !');
        }
        return view('admin.specialized.add_edit', compact('specialized'));
    }

    public function update (RequestSpecialized $request, $id)
    {
        if($id)
        {
            $specialized = Specialized::find($id);
            if(empty($specialized)) return redirect()->back()->with('error', 'Chuyên ngành không tồn tại !');
        }

        $data = $request->except("_token");
        $specialized->update($data);
        return redirect()->route('get.specialized.index')->with('success', 'Cập nhật chuyên ngành thành công !');
    }
}

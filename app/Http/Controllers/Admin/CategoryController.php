<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index ()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create ()
    {
        return view('admin.category.add_edit');
    }

    public function store (RequestCategory $request)
    {
        $data = $request->except("_token");
        $request->has('status') ? $data['status'] = 1 : $data['status'] = 0;
        Category::insert($data);
        return redirect()->route('get.category.index')->with('success', 'Thêm mới danh mục thành công !');
    }

    public function edit ($id)
    {
        $category = Category::find($id);
        if(empty($category))
        {
            return redirect()->back()->with('error', 'Danh mục không tồn tại !');
        }
        return view('admin.category.add_edit', compact('category'));
    }

    public function update (RequestCategory $request, $id)
    {
        if($id)
        {
            $category = Category::find($id);
            if(empty($category)) return redirect()->back()->with('error', 'Danh mục không tồn tại !');
        }

        $data = $request->except("_token");
        $request->has('status') ? $data['status'] = 1 : $data['status'] = 0;
        $category->update($data);
        return redirect()->route('get.category.index')->with('success', 'Cập nhật danh mục thành công !');
    }

    public function action ($action, $id)
    {
        if($action)
        {
            $category = Category::find($id);
            if(empty($category))
            {
                return redirect()->back()->with('error', 'Danh mục không tồn tại !');
            }
            switch ($action)
            {
                case 'delete':
                    $category->delete();
                    return redirect()->back()->with('success', 'Xóa danh mục thành công !');
                case 'status':
                    $category->status = $category->status ? 0 : 1;
                    $category->save();
                    return redirect()->back()->with('success', 'Cập nhật danh mục thành công !');
            }
        }
    }
}

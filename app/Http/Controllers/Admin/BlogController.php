<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestBlog;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $kw_title = $request->kw_title;
        $kw_status = $request->kw_status;
        $kw_date_from = $request->kw_date_from;
        $kw_date_to = $request->kw_date_to;

        $blogs = Blog::with('admin:id,full_name');

        if(trim($kw_title)){
            $blogs->where('title','like','%'.$kw_title.'%' );
        }

        if($kw_status>=0 && $kw_status !=null){
            $blogs->where('status',$kw_status);
        }

        if($kw_date_from){
            $blogs->where('created_at','>=', $kw_date_from." 00:00:00");
        }

        if($kw_date_to){
            $blogs->where('created_at','<=', $kw_date_to." 23:59:59");
        }

        $blogs = $blogs->orderByDesc('id')
            ->paginate(10);
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.add_edit');
    }

    public function store(RequestBlog $request)
    {
        try {
            $this->insertOrUpdate($request);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('get.blog.index')->with('success', 'Thêm mới tin tức thành công !');
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        if (empty($blog)) {
            return redirect()->back()->with('error', 'Tin tức không tồn tại !');
        }
        return view('admin.blog.add_edit', compact('blog'));
    }

    public function update(RequestBlog $request, $id)
    {

        try {
            $this->insertOrUpdate($request, $id);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->route('get.blog.index')->with('success', 'Cập nhật tin tức thành công !');
    }

    public function insertOrUpdate($request, $id = '')
    {
        $blog = new Blog();
        if ($id) {
            $blog = Blog::find($id);
            if (empty($blog)) return redirect()->back()->with('error', 'Tin tức không tồn tại !');
        }

        $blog->title = $request->title;
        $request->has('status') ? $blog->status = 1 : $blog->status = 0;
        $blog->url_key = !empty($request->url_key) ? Str::slug($request->url_key, '-') : Str::slug($request->title, '-');
        $blog->description = $request->description;
        $blog->content = $request->content;
        $blog->admin_id = \Auth::user()->id;


        if ($request->hasFile('thumbnail')) {
            $extension = $request->thumbnail->extension();
            $filename = 'blogs-' . uniqid() . '.' . $extension;
            $blog->thumbnail = $request->thumbnail->storeAs('blogs', $filename, 'public');
        }

        $blog->save();
    }

    public function action($action, $id)
    {
        if ($action) {
            $blog = Blog::find($id);
            if (empty($blog)) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại !');
            }
            switch ($action) {
                case 'delete':
                    $blog->delete();
                    return redirect()->back()->with('success', 'Xóa tin tức thành công !');
                case 'status':
                    $blog->status = $blog->status ? 0 : 1;
                    $blog->save();
                    return redirect()->back()->with('success', 'Cập nhật tin tức thành công !');
            }
        }
    }
}

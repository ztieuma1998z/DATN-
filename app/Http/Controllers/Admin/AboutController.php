<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestAboutPage;
use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        $aboutPages = AboutPage::limit(1)->get();
        return view('admin.about.index', compact('aboutPages'));
    }

    public function edit($id)
    {
        $aboutPage = AboutPage::find($id);
        if(empty($aboutPage))
        {
            return redirect()->back()->with('error', 'Trang giới thiệu không tồn tại !');
        }
        return view('admin.about.edit', compact('aboutPage'));
    }

    public function update(RequestAboutPage $request, $id)
    {
        $data = $request->except("_token");

        // get request image
        if ($request->hasFile('image')){
            $extension = $request->image->extension();
            $filename = 'about-' . uniqid() . '.' . $extension;
            $data['image'] = $request->image->storeAs('abouts', $filename, 'public');

        }

        AboutPage::find($id)->update($data);

        return redirect()->route('get.about.index')->with('success', 'Cập nhật trang giới thiệu thành công !');
    }
}

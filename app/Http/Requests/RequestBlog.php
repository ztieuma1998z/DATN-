<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestBlog extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id;

        if(!empty($id)) {
            return [
                'title' => 'required|unique:blogs,title,'.$id.'id',
                'url_key' => 'unique:blogs,url_key,'.$id.'id',
                'description' => 'required',
                'thumbnail' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            ];
        }

        return [
            'title' => 'required|unique:blogs,title,'.$id.'id',
            'url_key' => 'unique:blogs,url_key,'.$id.'id',
            'description' => 'required',
            'thumbnail' => 'required|file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tiêu đề tin tức !',
            'title.unique' => 'Tên tiêu đề tin tức đã tồn tại !',
            'url_key.unique' => 'Tên url key tin tức đã tồn tại !',
            'description.required' => 'Nhập mô tả tin tức !',
            'thumbnail.required' => 'Nhập ảnh tin tức !',
            'thumbnail.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'thumbnail.max' => 'Dung lượng ảnh không vượt quá 1MB !',
        ];
    }
}

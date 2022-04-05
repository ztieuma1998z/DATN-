<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAboutPage extends FormRequest
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
        return [
            'title' => 'required',
            'content' => 'required',
            'image' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tiêu đề giới thệu !',
            'content.required' => 'Nhập nội dung giới thiệu !',
            'image' => 'Nhập ảnh trang giới thiệu !',
            'image.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'image.max' => 'Dung lượng ảnh không vượt quá 1MB !',
        ];
    }
}

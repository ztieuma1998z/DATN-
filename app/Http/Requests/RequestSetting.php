<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestSetting extends FormRequest
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
            'favicon' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            'logo' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            'banner' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            'banner_title' => 'required',
            'banner_description' => 'required',
            'banner_home' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            'banner_home_title' => 'required',
            'banner_home_description' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'copyright' => 'required',
            'link_fanpage' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'favicon.mimes' => 'Ảnh favicon phải là đuôi jpeg,jpg,bmp,png,gif !',
            'favicon.max' => 'Dung lượng ảnh favicon không vượt quá 1MB !',
            'logo.mimes' => 'Ảnh logo phải là đuôi jpeg,jpg,bmp,png,gif !',
            'logo.max' => 'Dung lượng ảnh logo không vượt quá 1MB !',
            'banner.mimes' => 'Ảnh banner phải là đuôi jpeg,jpg,bmp,png,gif !',
            'banner.max' => 'Dung lượng ảnh banner không vượt quá 1MB !',
            'banner_home.mimes' => 'Ảnh banner trang chủ phải là đuôi jpeg,jpg,bmp,png,gif !',
            'banner_home.max' => 'Dung lượng ảnh banner trang chủ không vượt quá 1MB !',
            'banner_title' => 'Nhập tiêu đề banner website !',
            'banner_description' => 'Nhập mô tả banner website !',
            'banner_home_title' => 'Nhập tiêu đề banner trang chủ !',
            'banner_home_description' => 'Nhập mô tả banner trang chủ !',
            'phone' => 'Nhập số điện thoại !',
            'email' => 'Nhập địa chỉ email !',
            'address' => 'Nhập địa chỉ !',
            'copyright' => 'Nhập copyright !',
            'link_fanpage' => 'Nhập link iframe fanpage !',
        ];
    }
}

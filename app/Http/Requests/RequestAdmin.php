<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAdmin extends FormRequest
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

        if (!empty($id)) {
            return [
                'full_name' => 'required',
                'phone' => 'required|numeric|gte:-1|unique:admins,phone,' . $id . 'id',
                'email' => 'required|email|unique:admins,email,' . $id . 'id',
                'avatar' => 'mimes:jpeg,jpg,bmp,png|max:1024',
            ];
        }

        return [
            'full_name' => 'required',
            'phone' => 'required|numeric|gte:-1|unique:admins,phone,' . $id . 'id',
            'email' => 'required|email|unique:admins,email,' . $id . 'id',
            'avatar' => 'required|mimes:jpeg,jpg,bmp,png|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'Số điện thoại đã tồn tại !',
            'full_name.required' => 'Nhập tên !',
            'phone.required' => 'Vui lòng nhập số điện thoại !',
            'phone.regex' => 'Số điện thoại không chính xác !',
            'phone.numeric' => 'Số điện thoại phải bằng số !',
            'email.required' => 'Nhập địa chỉ email !',
            'email.unique' => 'Tên email đã tồn tại !',
            'email.email' => 'Sai định dạng email !',
            'avatar.required' => 'Vui lòng thêm ảnh !',
            'avatar.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'avatar.max' => 'Dung lượng ảnh không vượt quá 1MB !',
        ];
    }
}

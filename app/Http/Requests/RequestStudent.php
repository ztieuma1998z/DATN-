<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStudent extends FormRequest
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
                'code' => 'required|unique:students,code,' . $id . 'id',
                'phone' => 'required|numeric|gte:-1|unique:students,phone,' . $id . 'id',
                'email' => 'required|email|unique:students,email,' . $id . 'id',
                'address' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'avatar' => 'mimes:jpeg,jpg,bmp,png|max:1024',
            ];
        }

        return [
            'full_name' => 'required',
            'phone' => 'required|numeric|gte:-1|unique:students,phone,' . $id . 'id',
            'email' => 'required|email|unique:students,email,' . $id . 'id',
            'address' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'avatar' => 'required|mimes:jpeg,jpg,bmp,png|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Nhập mã học sinh !',
            'code.unique' => 'Mã đã tồn tại !',
            'phone.unique' => 'Số điện thoại đã tồn tại !',
            'full_name.required' => 'Nhập tên !',
            'phone.required' => 'Vui lòng nhập số điện thoại !',
            'phone.regex' => 'Số điện thoại không chính xác !',
            'phone.numeric' => 'Số điện thoại phải bằng số !',
            'email.required' => 'Nhập địa chỉ email !',
            'email.unique' => 'Tên email đã tồn tại !',
            'email.email' => 'Sai định dạng email !',
            'address.required' => 'Nhập địa chỉ !',
            'gender.required' => 'Nhập giới tính !',
            'birth_date.required' => 'Nhập ngày sinh !',
            'avatar.required' => 'Nhập ảnh học sinh !',
            'avatar.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'avatar.max' => 'Dung lượng ảnh không vượt quá 1MB !',
        ];
    }
}

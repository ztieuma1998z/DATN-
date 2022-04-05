<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestTeacher extends FormRequest
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
                'code' => 'required|unique:teachers,code,' . $id . 'id',
                'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|unique:teachers,phone,' . $id . 'id',
                'email' => 'email|unique:teachers,email,' . $id . 'id',
                'address' => 'required',
                'specialized_id' => 'required',
                'gender' => 'required',
                'birth_date' => 'required',
                'avatar' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            ];
        }

        return [
            'full_name' => 'required',
            'phone' => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|unique:teachers,phone,' . $id . 'id',
            'email' => 'email|unique:teachers,email,' . $id . 'id',
            'address' => 'required',
            'specialized_id' => 'required',
            'gender' => 'required',
            'birth_date' => 'required',
            'avatar' => 'required|file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Nhập họ tên !',
            'code.required' => 'Nhập mã giáo viên !',
            'code.unique' => 'Mã đã tồn tại !',
            'phone.unique' => 'Số điện thoại đã tồn tại !',
            'phone.required' => 'Vui lòng nhập số điện thoại !',
            'phone.regex' => 'Số điện thoại không chính xác !',
            'phone.numeric' => 'Số điện thoại phải bằng số !',
            'email.unique' => 'Tên email đã tồn tại !',
            'email.email' => 'Sai định dạng email !',
            'address.required' => 'Nhập địa chỉ !',
            'specialized_id.required' => 'Chọn chuyên nghành !',
            'gender.required' => 'Nhập giới tính !',
            'birth_date.required' => 'Nhập ngày sinh !',
            'avatar.required' => 'Nhập ảnh giáo viên !',
            'avatar.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'avatar.max' => 'Dung lượng ảnh không vượt quá 1MB !',
        ];
    }
}

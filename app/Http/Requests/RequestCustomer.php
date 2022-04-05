<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCustomer extends FormRequest
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
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'course_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Nhập tên họ tên !',
            'phone.required' => 'Nhập số điện thoại !',
            'email.required' => 'Nhập email !',
            'course_id.required' => 'Nhập môn học !',
        ];
    }
}

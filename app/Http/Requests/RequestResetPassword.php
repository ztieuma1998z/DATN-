<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestResetPassword extends FormRequest
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
            'password' => 'required|between:6,18|confirmed',
            'old_password' => 'required',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'password.between' => 'Mật khẩu phải trong khoảng 6 đến 18 ký tự',
            'old_password.required' => 'Vui lòng nhập mật khẩu cũ',
            'password_confirmation.required' => 'Vui lòng nhập mật khẩu mới',
        ];
    }
}

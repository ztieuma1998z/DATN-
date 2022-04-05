<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestNotification extends FormRequest
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
            'title' => 'required|unique:notifications,title,'.$this->id.'id',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nhập tiêu đề thông báo !',
            'title.unique' => 'Tên tiêu đề thông báo đã tồn tại !',
            'category_id.required' => 'Nhập danh mục !',
        ];
    }
}

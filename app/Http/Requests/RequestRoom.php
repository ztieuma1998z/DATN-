<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestRoom extends FormRequest
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
            'name' => 'required|unique:rooms,name,'.$this->id.'id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập Tên phòng học !',
            'name.unique' => 'Tên phòng đã tồn tại !',
        ];
    }
}

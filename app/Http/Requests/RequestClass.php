<?php

namespace App\Http\Requests;

use App\Models\ClassModel;
use Illuminate\Foundation\Http\FormRequest;

class RequestClass extends FormRequest
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
            $class = ClassModel::where('end_date', null)->find($id);
            if($class) {
                return [
                    'name' => 'required|unique:classes,name,'.$this->id.'id',
                    'population' => 'required|numeric|between:5,50',
                    'number_of_sessions' => 'required|numeric|between:5,50',
                    'course_id' => 'required',
                    'start_date' => 'required|after:today',
                ];
            }

            return [
                'name' => 'required|unique:classes,name,'.$this->id.'id',
                'population' => 'required|numeric|between:5,50',
                'number_of_sessions' => 'required|numeric|between:5,50',
                'course_id' => 'required',
                'start_date' => 'required',
            ];

        }else {
            return [
                'name' => 'required|unique:classes,name,'.$this->id.'id',
                'population' => 'required|numeric|between:5,50',
                'number_of_sessions' => 'required|numeric|between:5,50',
                'course_id' => 'required',
                'start_date' => 'required|after:today',
            ];
        }

    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên lớp học !',
            'name.unique' => 'Tên lớp đã tồn tại !',
            'population.required' => 'Nhập sỹ số tối đa lớp học !',
            'population.between' => 'Nhập sỹ số phải trong khoảng từ 5 đến 50 !',
            'number_of_sessions.required' => 'Nhập số buổi học !',
            'number_of_sessions.between' => 'Số buổi học phải trong khoảng từ 5 đến 50 !',
            'course_id.required' => 'Nhập môn học cho lớp!',
            'start_date.required' => 'Nhập ngày bắt đầu !',
            'start_date.after' => 'Ngày bắt đầu phải là ngày trong tương lai !',
        ];
    }
}

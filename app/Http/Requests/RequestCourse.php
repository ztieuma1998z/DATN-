<?php

namespace App\Http\Requests;

use App\Models\ClassModel;
use Illuminate\Foundation\Http\FormRequest;

class RequestCourse extends FormRequest
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
        if(!empty($id)) {
            $classes = ClassModel::where('course_id', $id)->get();

            if (($classes->count())) {
                return [
                    'name' => 'required|unique:courses,name,'.$id.'id',
                    'thumbnail' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
                    'price' => 'required|numeric|min:1',
                    'specialized_id' => 'required',
                    'description' => 'required',
                ];
            }else{
                return [
                    'name' => 'required|unique:courses,name,'.$id.'id',
                    'thumbnail' => 'file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
                    'price' => 'required|numeric|min:1',
                    'specialized_id' => 'required',
                    'number_of_sessions' => 'required|numeric|between:5,50',
                    'description' => 'required',
                ];
            }
        }

        return [
            'name' => 'required|unique:courses,name,'.$id.'id',
            'thumbnail' => 'required|file|mimes:jpeg,jpg,bmp,png,gif|max:1024',
            'price' => 'required|numeric|min:1',
            'specialized_id' => 'required',
            'number_of_sessions' => 'required|numeric|between:5,50',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập tên môn học !',
            'name.unique' => 'Tên môn học đã tồn tại !',
            'price.required' => 'Nhập giá môn học !',
            'price.min' => 'Giá môn học phải lớn hơn 0 !',
            'description.required' => 'Nhập mô tả môn học !',
            'thumbnail.required' => 'Nhập ảnh môn !',
            'thumbnail.mimes' => 'Ảnh phải là đuôi jpeg,jpg,bmp,png,gif !',
            'thumbnail.max' => 'Dung lượng ảnh không vượt quá 1MB !',
            'number_of_sessions.required' => 'Nhập số buổi học !',
            'number_of_sessions.between' => 'Số buổi học phải trong khoảng từ 5 đến 50 !',
            'specialized_id.required' => 'Chọn chuyên nghành !',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Shift;

class RequestShift extends FormRequest
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
            'name' => 'required|unique:shifts,name,'.$this->id.'id',
            'start_at' => [
                'required',
                function($name, $value, $fail) {
                    if (empty($this->id)) {
                        $checkStart = Shift::whereTime('start_at','<=', $value)
                            ->whereTime('end_at','>=', $value)
                            ->first();
                    }else{
                        $checkStart = Shift::whereTime('start_at','<=', $value)
                            ->whereTime('end_at','>=', $value)
                            ->where('id','!=',$this->id)
                            ->first();
                    }

                    if(!empty($checkStart)){
                        $times = Shift::all();
                        $timeString = '';
                        foreach ($times as $time){
                            $timeString .= "$time->name ($time->start_at - $time->end_at);";
                        }
                        return $fail('Thời gian bắt đầu ca học đã tồn tại ở trong các ca học sau: "'.$timeString.'"');
                    }
                }
            ],
            'end_at' => [
                'required',
                'after:start_at',
                function($name, $value, $fail) {
                    if (empty($this->id)) {
                        $checkStart = Shift::whereTime('start_at','<=', $value)
                            ->whereTime('end_at','>=', $value)
                            ->first();
                    }else{
                        $checkStart = Shift::whereTime('start_at','<=', $value)
                            ->whereTime('end_at','>=', $value)
                            ->where('id','!=',$this->id)
                            ->first();
                    }

                    if(!empty($checkStart)){
                        $times = Shift::all();
                        $timeString = '';
                        foreach ($times as $time){
                            $timeString .= "$time->name ($time->start_at - $time->end_at);";
                        }
                        return $fail('Thời gian kết thúc ca học đã tồn tại ở trong các ca học sau: "'.$timeString.'"');
                    }
                }
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nhập Tên ca học !',
            'name.unique' => 'Tên ca học đã tồn tại !',
            'start_at.required' => 'Nhập thời gian bắt đầu',
            'end_at.required' => 'Nhập thời gian kết thúc',
            'end_at.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu',
        ];
    }
}

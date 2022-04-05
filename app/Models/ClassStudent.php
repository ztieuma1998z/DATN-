<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    protected $table = 'class_student';
    protected $guarded = [''];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class,'class_id');
    }
}

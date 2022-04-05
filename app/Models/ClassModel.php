<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $guarded = [''];


    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    public function classStudent()
    {
        return $this->hasMany(ClassStudent::class, 'class_id');
    }
}

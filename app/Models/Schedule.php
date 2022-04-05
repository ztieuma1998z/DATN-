<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $guarded = [''];

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class,'class_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class,'room_id');
    }

    public function weekday()
    {
        return $this->belongsTo(Weekday::class,'weekday_id');
    }

    public function rollCall()
    {
        return $this->hasMany(RollCall::class, 'schedule_id');
    }
}

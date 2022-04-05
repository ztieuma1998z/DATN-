<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $guarded = [''];

    public function specialized()
    {
        return $this->belongsTo(Specialized::class,'specialized_id');
    }
}

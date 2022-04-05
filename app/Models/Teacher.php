<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    protected $table = 'teachers';
    protected $guard = [''];

    protected $status_teacher = [
        1 => [
            'name' => 'Hoạt động',
            'class' => 'badge-success',
            'icon' => 'fa-eye'
        ],
        0 => [
            'name' => 'Tạm ngừng',
            'class' => 'badge-danger',
            'icon' => 'fa-eye-slash'
        ]
    ];

    public function getStatus()
    {
        return Arr::get($this->status_teacher, $this->status, '[N/A]');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function specialized()
    {
        return $this->belongsTo(Specialized::class,'specialized_id');
    }
}

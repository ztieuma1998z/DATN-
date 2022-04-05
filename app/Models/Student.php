<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Arr;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guard = [''];

    protected $hidden = ['password'];

    protected $status_student = [
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
        return Arr::get($this->status_student, $this->status, '[N/A]');
    }
}

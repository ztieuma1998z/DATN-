<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $guarded = [''];

    const STATUS_PUBLIC = 1;
    const STATUS_PRIVATE = 0;

    protected $status_blog = [
        1 => [
            'name' => 'Hiển thị',
            'class' => 'badge-success',
            'icon' => 'fa-eye'
        ],
        0 => [
            'name' => 'Ẩn',
            'class' => 'badge-danger',
            'icon' => 'fa-eye-slash'
        ]
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function getStatus()
    {
        return Arr::get($this->status_blog, $this->status, '[N/A]');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $guarded = [''];

    const STATUS_PUBLIC = 1;
    const STATUS_PRIVATE = 0;

    protected $status_notification = [
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

    public function getStatus()
    {
        return Arr::get($this->status_notification, $this->status, '[N/A]');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }
}

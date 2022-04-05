<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;


class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = [''];

    const STATUS_PUBLIC = 1;
    const STATUS_PRIVATE = 0;

    protected $status_category = [
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
        return Arr::get($this->status_category, $this->status, '[N/A]');
    }

    public function notifications() {
        return $this->hasManyThrough(Notification::class, Category::class,'id', 'category_id');
    }
}

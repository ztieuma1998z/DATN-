<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Customer extends Model
{
    protected $table = 'customers';
    protected $guarded = [''];

    protected $status_customer = [
        1 => [
            'name' => 'Chờ tư vấn',
            'class' => 'badge-danger',
        ],
        2 => [
            'name' => 'Đang tư vấn',
            'class' => 'badge-yellow',
        ],
        3 => [
            'name' => 'Đã tư vấn',
            'class' => 'badge-success',
        ]
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }

    public function getStatus()
    {
        return Arr::get($this->status_customer, $this->status, '[N/A]');
    }
}

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
|
| Router dành cho các trang thuộc về giáo viên
|
*/
Route::group([
    'prefix' => 'giao-vien',
    'namespace' => 'Teacher',
    'middleware' => 'auth:teacher'
], function() {
    // xem lịch dạy
    Route::get('/lich-day', 'ScheduleController@index')->name('teacher.index');

    // lớp phụ trách
    Route::get('/lop-phu-trach', 'ChargeClassController@index')->name('teacher.chargeclass.index');
    Route::post('/list-student-by-class', 'ChargeClassController@showListStudentClass')->name('show.list.student.class');

    // xem lịch dạy theo lớp
    Route::get('/lich-day-theo-lop/{id}', 'ScheduleClassController@index')->name('teacher.scheduleclass.index');

    // điểm danh
    Route::get('/diem-danh/{idSchedule}/{idClass}', 'RollCallController@index')->name('teacher.rollcall.index');

    // thông tin cá nhân
    Route::get('/thong-tin-ca-nhan', 'ProfileController@index')->name('teacher.profile.index');

});

<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Router dành cho các trang của học sinh
|
*/
Route::group([
    'prefix' => 'hoc-sinh',
    'namespace' => 'Student',
    'middleware' => 'auth:student'
], function() {
    // Thông báo
    Route::get('/', 'NotificationController@index')->name('student.index');
    Route::get('/thong-bao/{id}', 'NotificationController@detail')->name('student.notification.detail');

    // thông tin cá nhân
    Route::get('/thong-tin-ca-nhan', 'ProfileController@index')->name('student.profile.index');

    // lịch học
    Route::get('/lich-hoc', 'ScheduleController@index')->name('student.schedule.index');

    // Điểm danh
    Route::get('/diem-danh', 'RollCallController@index')->name('student.rollcall.index');

    // lịch sử học
    Route::get('/lich-su-hoc', 'HistoryLearnController@index')->name('student.historylearn.index');

});

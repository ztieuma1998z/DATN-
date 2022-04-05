<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Router dành cho các trang quản lý
|
*/
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth:admin'
], function () {
    // trang chủ
    Route::get('/', 'DashboardController@index')->name('admin.index');

    // thông báo
    Route::get('/notification', 'NotificationController@index')->name('get.notification.index');
    Route::get('/notification/add', 'NotificationController@create')->name('get.notification.create');
    Route::post('/notification/add', 'NotificationController@store');
    Route::get('/notification/edit/{id}', 'NotificationController@edit')->name('get.notification.edit');
    Route::post('/notification/edit/{id}', 'NotificationController@update');
    Route::get('/notification/{action}/{id}', 'NotificationController@action')->name('get.notification.action');

    // thông tin cá nhân
    Route::get('/profile', 'ProfileController@index')->name('get.profile.index');

    // danh mục
    Route::get('/category', 'CategoryController@index')->name('get.category.index');
    Route::get('/category/add', 'CategoryController@create')->name('get.category.create');
    Route::post('/category/add', 'CategoryController@store');
    Route::get('/category/edit/{id}', 'CategoryController@edit')->name('get.category.edit');
    Route::post('/category/edit/{id}', 'CategoryController@update');
    Route::get('/category/{action}/{id}', 'CategoryController@action')->name('get.category.action');

    // tin tức
    Route::get('/blog', 'BlogController@index')->name('get.blog.index');
    Route::get('/blog/add', 'BlogController@create')->name('get.blog.create');
    Route::post('/blog/add', 'BlogController@store');
    Route::get('/blog/edit/{id}', 'BlogController@edit')->name('get.blog.edit');
    Route::post('/blog/edit/{id}', 'BlogController@update');
    Route::get('/blog/{action}/{id}', 'BlogController@action')->name('get.blog.action');

    // giới thiệu
    Route::get('/about', 'AboutController@index')->name('get.about.index');
    Route::get('/about/edit/{id}', 'AboutController@edit')->name('get.about.edit');
    Route::post('/about/edit/{id}', 'AboutController@update');
    // cấu hình trung tâm
    Route::get('/setting', 'SettingController@index')->name('get.setting.index');
    Route::get('/setting/edit/{id}', 'SettingController@edit')->name('get.setting.edit');
    Route::post('/setting/edit/{id}', 'SettingController@update');

    // lớp học
    Route::get('/class', 'ClassController@index')->name('get.class.index');
    Route::get('/class/add', 'ClassController@create')->name('get.class.create');
    Route::post('/class/add', 'ClassController@store');
    Route::get('/class/edit/{id}', 'ClassController@edit')->name('get.class.edit');
    Route::post('/class/edit/{id}', 'ClassController@update');
    Route::get('class/schedule/{id}', 'ClassController@schedule')->name('get.class.schedule.index');

    Route::post('/list-student-by-class', 'ClassController@showListStudentClass')->name('list.student.by.class');

    Route::post('/get-number-of-sessions', 'ClassController@getNumberSession')->name('get.number.of.sessions');

    // điểm danh
    Route::get('class/roll-call/{idSchedule}/{idClass}', 'RollCallController@index')->name('get.roll-call.index');
    Route::post('class/save/roll-call', 'RollCallController@save')->name('post.save.roll-call');

    // khách hàng

    Route::get('/customer', 'CustomerController@index')->name('get.customer.index');
    Route::get('/customer/status/{id}', 'CustomerController@status')->name('get.customer.status');
    Route::get('/customer/delete/{id}', 'CustomerController@delete')->name('get.customer.delete');

    // khóa học
    Route::get('/course', 'CourseController@index')->name('get.course.index');
    Route::get('/course/add', 'CourseController@create')->name('get.course.create');
    Route::post('/course/add', 'CourseController@store');
    Route::get('/course/edit/{id}', 'CourseController@edit')->name('get.course.edit');
    Route::post('/course/edit/{id}', 'CourseController@update');
    Route::get('/course/delete/{id}', 'CourseController@delete')->name('get.course.delete');

    // học sinh
    Route::get('/student', 'StudentController@index')->name('get.student.index');
    Route::get('/student/add', 'StudentController@create')->name('get.student.create');
    Route::post('/student/add', 'StudentController@store');
    Route::get('/student/edit/{id}', 'StudentController@edit')->name('get.student.edit');
    Route::post('/student/edit/{id}', 'StudentController@update');
    Route::get('/student/{action}/{id}', 'StudentController@action')->name('get.student.action');
    Route::post('/show-information-student', 'StudentController@showInformationStudent')->name('get.information.student');


    // phòng học
    Route::get('/room', 'RoomController@index')->name('get.room.index');
    Route::get('/room/add', 'RoomController@create')->name('get.room.create');
    Route::post('/room/add', 'RoomController@store');
    Route::get('/room/edit/{id}', 'RoomController@edit')->name('get.room.edit');
    Route::post('/room/edit/{id}', 'RoomController@update');
    Route::get('/room/delete/{id}', 'RoomController@delete')->name('get.room.delete');


    // ca học
    Route::get('/shift', 'ShiftController@index')->name('get.shift.index');
    Route::get('/shift/add', 'ShiftController@create')->name('get.shift.create');
    Route::post('/shift/add', 'ShiftController@store');
    Route::get('/shift/edit/{id}', 'ShiftController@edit')->name('get.shift.edit');
    Route::post('/shift/edit/{id}', 'ShiftController@update');
    Route::get('/shift/delete/{id}', 'ShiftController@delete')->name('get.shift.delete');

    // giảng viên
    Route::get('/teacher', 'TeacherController@index')->name('get.teacher.index');
    Route::get('/teacher/add', 'TeacherController@create')->name('get.teacher.create');
    Route::post('/teacher/add', 'TeacherController@store');
    Route::get('/teacher/edit/{id}', 'TeacherController@edit')->name('get.teacher.edit');
    Route::post('/teacher/edit/{id}', 'TeacherController@update');
    Route::get('/teacher/{action}/{id}', 'TeacherController@action')->name('get.teacher.action');
    Route::post('/show-information-teacher', 'TeacherController@showInformationTeacher')->name('get.information.teacher');

    // qtv
    Route::get('/admin', 'AdminController@index')->name('get.admin.index');
    Route::get('/admin/add', 'AdminController@create')->name('get.admin.create');
    Route::post('/admin/add', 'AdminController@store');
    Route::get('/admin/edit/{id}', 'AdminController@edit')->name('get.admin.edit');
    Route::post('/admin/edit/{id}', 'AdminController@update');
    Route::get('/admin/{action}/{id}', 'AdminController@action')->name('get.admin.action');

    // Danh sách học sinh theo lớp
    Route::get('/student-by-class/{id}', 'StudentClassController@index')->name('get.studentbyclass.index');
    Route::post('/show-modal-add-student', 'StudentClassController@showModalAddStudent')->name('show.modal.add.student');
    Route::post('/save-student-by-class', 'StudentClassController@saveStudentByClass')->name('save.student.by.class');
    Route::post('/show-modal-change-student', 'StudentClassController@showModalChangeStudent')->name('show.modal.change.student');
    Route::post('/change-select-class', 'StudentClassController@checkSelectClass')->name('change.select.class');
    Route::post('/save-change-student-by-class', 'StudentClassController@saveChangeStudentByClass')->name('save.change.student.by.class');

    Route::post('/search-list-student-by-class', 'StudentClassController@searchStudentByClass')->name('search.student.by.class');
    Route::post('/filter-list-student-by-class', 'StudentClassController@filterStudentByClass')->name('filter.student.by.class');

    // Xếp lịch học
    Route::get('/schedule', 'ScheduleController@index')->name('get.schedule.index');
    Route::post('/schedule', 'ScheduleController@store');
    Route::post('/show-modal', 'ScheduleController@getAjaxClass')->name('get.ajax.class');
    Route::post('/schedule/view', 'ScheduleController@getScheduleView')->name('get.schedule.view');
    Route::post('/check-shift-by-room', 'ScheduleController@checkShiftByRoom')->name('check.shift.by.room');
    Route::post('/show-modal-change-schedule', 'ScheduleController@showModalChangeSchedule')->name('show.modal.change.schedule');
    Route::post('/change-schedule', 'ScheduleController@saveChangeSchedule')->name('post.change.schedule');
    Route::post('/change-schedule-by-date-to', 'ScheduleController@changeScheduleByDateTo')->name('change.schedule.by.date.to');
    Route::post('/change-schedule-check-shift-by-room', 'ScheduleController@changeScheduleCheckShiftByRoom')->name('change.schedule.check.shift.by.room');

    Route::post('/show-modal-edit-schedule', 'ScheduleController@showModalEditSchedule')->name('show.modal.edit.schedule');

    // Xếp lịch dạy
    Route::get('/teaching-schedule', 'TeachingScheduleController@index')->name('get.teaching.schedule.index');
    Route::post('/show-modal-teaching-schedule', 'TeachingScheduleController@showModalTeachingSchedule')->name('show.modal.teaching.schedule');
    Route::post('/save-modal-teaching-schedule', 'TeachingScheduleController@saveModalTeachingSchedule')->name('save.modal.teaching.schedule');
    Route::post('/show-detail-teaching-schedule', 'TeachingScheduleController@showDetailTeachingSchedule')->name('show.detail.teaching.schedule');

    // chuyên ngành
    Route::get('/specialized', 'SpecializedController@index')->name('get.specialized.index');
    Route::get('/specialized/add', 'SpecializedController@create')->name('get.specialized.create');
    Route::post('/specialized/add', 'SpecializedController@store');
    Route::get('/specialized/edit/{id}', 'SpecializedController@edit')->name('get.specialized.edit');
    Route::post('/specialized/edit/{id}', 'SpecializedController@update');


});

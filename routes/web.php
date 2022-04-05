<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Router dành cho trang ngoài, bao gồm các trang index, contact,...
|  //test
*/

//Trang chủ, nơi khách đến xem

Route::group([
    'namespace' => 'Frontend',
], function () {
    Route::get('/', 'HomeController@index')->name('get.home.page');
    Route::get('lien-he', 'ContactController@index')->name('get.contact.page');
    Route::get('gioi-thieu', 'AboutController@index')->name('get.about.page');
    // môn học
    Route::get('mon-hoc', 'CourseController@index')->name('get.course.page');
    Route::get('mon-hoc/{id}', 'CourseController@detail')->name('get.course.detail');
    // đăng ký form môn học
    Route::post('dang-ky', 'CustomerController@register')->name('post.customer.register');
    // tin tức
    Route::get('tin-tuc', 'BlogController@index')->name('get.blog.page');
    Route::get('tin-tuc/{slug}-{id}', 'BlogController@detail')->name('get.blog.detail');
});

Route::get('register', function () {
    return "Register Page";
})->name('register');

Route::post('register', function () {
    return "Register Page";
});

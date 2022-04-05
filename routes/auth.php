<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Router dành cho các trang liên quan đến xác thực tài khoản
|
*/
Route::group([
    'namespace' => 'Auth',
], function() {
    //Login
    Route::get('login', 'LoginController@loginForm')->name('login');
    Route::post('login', 'LoginController@authenticate')->name('login');

    //Reset Password
    Route::get('reset-password', 'ResetPasswordController@resetForm')->name('reset-password');
    Route::post('reset-password', 'ResetPasswordController@sendResetToken')->name('reset-password');

    Route::get('change-password/{role}/{token}', 'ResetPasswordController@resetPasswordForm')->name('reset-password-with-token');
    Route::post('change-password/{role}/{token}', 'ResetPasswordController@submitResetPassword')->name('reset-password-with-token');

    // change password
    Route::get('change-password','ChangePasswordController@index')->name('get.change.password');
    Route::post('change-password','ChangePasswordController@submitChangePassword')->name('post.change.password');


    Route::get('logout', function(){
        Auth::guard('admin')->logout();
        Auth::guard('teacher')->logout();
        Auth::guard('student')->logout();

        return redirect()->route('login');
    })->name('logout');
});


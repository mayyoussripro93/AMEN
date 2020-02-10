<?php

Route::prefix('employee')->name('employee.')->group(function () {
    Route::get('/', 'Employee\Auth\LoginController@showLoginForm');
    Route::get('/login', 'Employee\Auth\LoginController@showLoginForm');
    Route::post('/login', 'Employee\Auth\LoginController@login');
    Route::post('/logout', 'Employee\Auth\LoginController@logout');

    // Registration Routes...
    Route::get('/register', 'Employee\Auth\RegisterController@showRegistrationForm')->name('employee-register');
    Route::post('/register', 'Employee\Auth\RegisterController@register');
    Route::get('/password/reset', 'Employee\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('/password/email', 'Employee\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('/password/reset/{token}', 'Employee\Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('/password/reset', 'Employee\Auth\ResetPasswordController@reset');
});
Route::get('/login', 'Employee\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Employee\Auth\LoginController@login');
Route::post('/logout', 'Employee\Auth\LoginController@logout')->name('logout');

Route::get('/register', 'Employee\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Employee\Auth\RegisterController@register');

Route::get('/password/reset', 'Employee\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Employee\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Employee\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset', 'Employee\Auth\ResetPasswordController@reset');

Route::get('/after-register', function(){ return view('auth.after_register');})->name('after-register');
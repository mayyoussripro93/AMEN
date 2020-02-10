<?php

/* * ******  User Start ********** */
Route::get('list-employees', array_merge(['uses' => 'Admin\EmployeeController@indexUsers'], $all_users))->name('list.employees');
Route::get('create-employee', array_merge(['uses' => 'Admin\EmployeeController@createUser'], $all_users))->name('create.employee');
Route::post('store-employee', array_merge(['uses' => 'Admin\EmployeeController@storeUser'], $all_users))->name('store.employee');
Route::get('edit-employee/{id}', array_merge(['uses' => 'Admin\EmployeeController@editUser'], $all_users))->name('edit.employee');
Route::put('update-employee/{id}', array_merge(['uses' => 'Admin\EmployeeController@updateUser'], $all_users))->name('update.employee');

Route::delete('delete-employee', array_merge(['uses' => 'Admin\EmployeeController@deleteUser'], $all_users))->name('delete.employee');
Route::get('fetch-employees', array_merge(['uses' => 'Admin\EmployeeController@fetchUsersData'], $all_users))->name('fetch.data.employees');
Route::get('list-employees-deleted', array_merge(['uses' => 'Admin\EmployeeController@indexDeletedUsers'], $all_users))->name('list.employees.deleted');
Route::get('fetch-employees-deleted', array_merge(['uses' => 'Admin\EmployeeController@fetchUsersDeletedData'], $all_users))->name('fetch.data.employees.deleted');

Route::put('make-active-employee', array_merge(['uses' => 'Admin\EmployeeController@makeActiveUser'], $all_users))->name('make.active.employee');
Route::put('make-not-active-employee', array_merge(['uses' => 'Admin\EmployeeController@makeNotActiveUser'], $all_users))->name('make.not.active.employee');
Route::put('make-verified-employee', array_merge(['uses' => 'Admin\EmployeeController@makeVerifiedUser'], $all_users))->name('make.verified.employee');
Route::put('make-not-verified-employee', array_merge(['uses' => 'Admin\EmployeeController@makeNotVerifiedUser'], $all_users))->name('make.not.verified.employee');
Route::put('make-restore-employee', array_merge(['uses' => 'Admin\EmployeeController@makeRestoreUser'], $all_users))->name('make.restore.employee');

/* * ****** End User ********** */
?>
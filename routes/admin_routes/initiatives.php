<?php

/* * ******  Job Start ********** */
Route::get('list-initiatives', array_merge(['uses' => 'Admin\InitiativesController@indexInitiatives'], $all_users))->name('list.initiatives');
Route::get('create-initiatives', array_merge(['uses' => 'Admin\InitiativesController@createJob'], $all_users))->name('create.initiatives');
Route::post('store-initiatives', array_merge(['uses' => 'Admin\InitiativesController@storeJob'], $all_users))->name('store.initiatives');
Route::get('edit-initiatives/{id}', array_merge(['uses' => 'Admin\InitiativesController@editJob'], $all_users))->name('edit.initiatives');
Route::put('update-initiatives/{id}', array_merge(['uses' => 'Admin\InitiativesController@updateJob'], $all_users))->name('update.initiatives');
Route::delete('delete-initiatives', array_merge(['uses' => 'Admin\InitiativesController@deleteJob'], $all_users))->name('delete.initiatives');
Route::get('fetch-initiatives', array_merge(['uses' => 'Admin\InitiativesController@fetchInitiativesData'], $all_users))->name('fetch.data.initiatives');
Route::put('make-active-initiatives', array_merge(['uses' => 'Admin\InitiativesController@makeActiveJob'], $all_users))->name('make.active.initiatives');
Route::put('make-not-active-initiatives', array_merge(['uses' => 'Admin\InitiativesController@makeNotActiveJob'], $all_users))->name('make.not.active.initiatives');
Route::put('make-featured-initiatives', array_merge(['uses' => 'Admin\InitiativesController@makeFeaturedJob'], $all_users))->name('make.featured.initiatives');
Route::put('make-not-featured-initiatives', array_merge(['uses' => 'Admin\InitiativesController@makeNotFeaturedJob'], $all_users))->name('make.not.featured.initiatives');
Route::post('employee-states', array_merge(['uses' => 'Admin\InitiativesController@employeeStates'], $all_users))->name('employee.states');

/* * ****** End Job ********** */
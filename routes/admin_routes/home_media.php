<?php
Route::get('list-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@indexMedia'], $all_users))->name('list.homeMedia');
Route::get('create-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@createMedia'], $all_users))->name('create.homeMedia');
/////common//////////////////////////////
///
Route::post('store-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@store'], $all_users))->name('store.homeMedia');
Route::delete('delete-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@deleteMedia'], $all_users))->name('delete.homeMedia');
Route::get('fetch-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@fetchMediaData'], $all_users))->name('fetch.data.homeMedia');
Route::put('make-active-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@makeActiveMedia'], $all_users))->name('make.active.homeMedia');
Route::put('make-not-active-homeMedia', array_merge(['uses' => 'Admin\HomeMediaController@makeNotActiveMedia'], $all_users))->name('make.not.active.homeMedia');
?>
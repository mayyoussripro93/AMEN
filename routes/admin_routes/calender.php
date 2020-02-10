<?php

/* * ******  calender Start ********** */
Route::get('list-event', array_merge(['uses' => 'Admin\EventController@indexEvent'], $all_users))->name('list.event');
Route::get('create-event', array_merge(['uses' => 'Admin\EventController@createEvent'], $all_users))->name('create.event');
Route::post('store-event', array_merge(['uses' => 'Admin\EventController@storeEvent'], $all_users))->name('store.event');
Route::post('update-event',
    ['uses' => 'Admin\EventController@updateEvent', 'as' => 'update.event']);
Route::post('delete-event',
    ['uses' => 'Admin\EventController@deleteEvent', 'as' => 'delete.event']);

/* * ****** End calender ********** */
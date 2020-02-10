<?php

/* * ******  State Start ********** */
Route::get('list-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@indexStates'], $all_users))->name('list.danger.sub.cats');
Route::get('create-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@createState'], $all_users))->name('create.danger.sub.cats');
Route::post('store-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@storeState'], $all_users))->name('store.danger.sub.cats');
Route::get('edit-danger-sub-cats/{id}', array_merge(['uses' => 'Admin\DangersubCategoriesController@editState'], $all_users))->name('edit.danger.sub.cats');
Route::put('update-danger-sub-cats/{id}', array_merge(['uses' => 'Admin\DangersubCategoriesController@updateState'], $all_users))->name('update.danger.sub.cats');
Route::delete('delete-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@deleteState'], $all_users))->name('delete.danger.sub.cats');
Route::get('fetch-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@fetchStatesData'], $all_users))->name('fetch.data.danger.sub.cats');
Route::put('make-active-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@makeActiveState'], $all_users))->name('make.active.danger.sub.cats');
Route::put('make-not-active-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@makeNotActiveState'], $all_users))->name('make.not.active.danger.sub.cats');
Route::get('sort-danger-sub-cats', array_merge(['uses' => 'Admin\DangersubCategoriesController@sortStates'], $all_users))->name('sort.danger.sub.cats');
Route::get('danger-sub-cats-sort-data', array_merge(['uses' => 'Admin\DangersubCategoriesController@stateSortData'], $all_users))->name('danger.sub.cats.sort.data');
Route::put('danger-sub-cats-sort-update', array_merge(['uses' => 'Admin\DangersubCategoriesController@stateSortUpdate'], $all_users))->name('danger.sub.cats.sort.update');
/* * ****** End State ********** */
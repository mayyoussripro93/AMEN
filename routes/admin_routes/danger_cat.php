<?php

/* * ******  Country Start ********** */
Route::get('list-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@indexCountries'], $all_users))->name('list.danger.cats');
Route::get('create-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@createCountry'], $all_users))->name('create.danger.cats');
Route::post('store--danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@storeCountry'], $all_users))->name('store.danger.cats');
Route::get('edit-danger-cats/{id}', array_merge(['uses' => 'Admin\DangerCategoriesController@editCountry'], $all_users))->name('edit.danger.cats');
Route::put('update-danger-cats/{id}', array_merge(['uses' => 'Admin\DangerCategoriesController@updateCountry'], $all_users))->name('update.danger.cats');
Route::delete('delete-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@deleteCountry'], $all_users))->name('delete.danger.cats');
Route::get('fetch-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@fetchCountriesData'], $all_users))->name('fetch.data.danger.cats');
Route::put('make-active-danger.cats', array_merge(['uses' => 'Admin\DangerCategoriesController@makeActiveCountry'], $all_users))->name('make.active.danger.cats');
Route::put('make-not-active-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@makeNotActiveCountry'], $all_users))->name('make.not.active.danger.cats');
Route::get('sort-danger-cats', array_merge(['uses' => 'Admin\DangerCategoriesController@sortCountries'], $all_users))->name('sort.danger.cats');
Route::get('danger-cats-sort-data', array_merge(['uses' => 'Admin\DangerCategoriesController@countrySortData'], $all_users))->name('danger.cats.sort.data');
Route::put('danger-cats-sort-update', array_merge(['uses' => 'Admin\DangerCategoriesController@countrySortUpdate'], $all_users))->name('danger.cats.sort.update');
/* * ****** End Country ********** */

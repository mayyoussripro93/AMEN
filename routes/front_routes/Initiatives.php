<?php

Route::get('initiatives/{slug}', 'Initiatives\InitiativesController@InitiativesDetail')->name('Initiatives.detail');
Route::get('apply/{slug}', 'Job\JobController@applyJob')->name('apply.job');
Route::post('apply/{slug}', 'Job\JobController@postApplyJob')->name('post.apply.job');
Route::get('initiatives', 'Initiatives\InitiativesController@InitiativesBySearch')->name('Initiatives.list');
Route::get('initiatives/all', 'Initiatives\InitiativesController@InitiativesALLBySearch')->name('Initiatives.All.list');
Route::get('add-to-favourite-job/{job_slug}', 'Job\JobController@addToFavouriteJob')->name('add.to.favourite');
Route::get('remove-from-favourite-job/{job_slug}', 'Job\JobController@removeFromFavouriteJob')->name('remove.from.favourite');
Route::get('my-job-applications', 'Job\JobController@myJobApplications')->name('my.job.applications');
Route::get('my-favourite-jobs', 'Job\JobController@myFavouriteJobs')->name('my.favourite.jobs');
Route::get('post-initiatives', 'Initiatives\InitiativesPublishController@createFrontInitiatives')->name('post.Initiatives');
Route::post('store-front-initiatives', 'Initiatives\InitiativesPublishController@storeFrontInitiatives')->name('store.front.Initiatives');
Route::get('edit-front-initiatives/{id}', 'Initiatives\InitiativesPublishController@editFrontInitiatives')->name('edit.front.Initiatives');
Route::put('update-front-initiatives/{id}', 'Initiatives\InitiativesPublishController@updateFrontInitiatives')->name('update.front.Initiatives');
Route::delete('delete-front-initiatives', 'Initiatives\InitiativesPublishController@deleteInitiatives')->name('delete.front.Initiatives');
Route::get('initiatives-seekers', 'Job\JobSeekerController@jobSeekersBySearch')->name('Initiatives.seeker.list');
Route::get('join-initiatives/{id}', 'Initiatives\InitiativesPublishController@joinInitiatives')->name('join.initiatives');
Route::post('join-initiatives-post/{id}', 'Initiatives\InitiativesPublishController@joinInitiativesPost')->name('join.initiatives.post');
Route::get('join-initiatives-list/{id}', 'Initiatives\InitiativesPublishController@joinInitiativesList')->name('join.initiatives.list');

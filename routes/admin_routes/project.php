<?php

/* * ******  Project Start ********** */
Route::get('list-projects', array_merge(['uses' => 'Admin\ProjectController@indexProjects'], $all_users))->name('list.projects');
Route::get('create-project', array_merge(['uses' => 'Admin\ProjectController@createProject'], $all_users))->name('create.project');
Route::post('store-project', array_merge(['uses' => 'Admin\ProjectController@storeProject'], $all_users))->name('store.project');
Route::get('edit-project/{id}', array_merge(['uses' => 'Admin\ProjectController@editProject'], $all_users))->name('edit.project');
Route::post('update-project', array_merge(['uses' => 'Admin\ProjectController@updateProject'], $all_users))->name('update.project');
Route::delete('delete-project', array_merge(['uses' => 'Admin\ProjectController@deleteProject'], $all_users))->name('delete.project');
Route::get('fetch-admin-projects', array_merge(['uses' => 'Admin\ProjectController@fetchProjectsData'], $all_users))->name('fetch.admin.data.projects');
Route::post('fetch-admin-state-employee', array_merge(['uses' => 'Admin\ProjectController@fetchStateEmployee'], $all_users))->name('fetch-admin-state-employee');
Route::post('fetch-latitudelongtiude',array_merge(['uses' => 'Admin\ProjectController@fetchlatitudelongtiude'], $all_users))->name('fetch.city.latlong');
/* * ****** End Project ********** */

/* * ******  violation Start ********** */
Route::get('list-violations/{project_id?}/', array_merge(['uses' => 'Admin\ProjectController@indexViolations'], $all_users))->name('list.violations');
Route::get('fetch-admin-data-violations', array_merge(['uses' => 'Admin\ProjectController@fetchViolationsData'], $all_users))->name('fetch.admin.data.violations');
Route::get('create-violation/{id}', array_merge(['uses' => 'Admin\ProjectController@CreateViolation'], $all_users))->name('create.violation');
Route::post('store-violation', array_merge(['uses' => 'Admin\ProjectController@StoreViolation'], $all_users))->name('store.violation');
Route::get('edit-violation/{id}', array_merge(['uses' => 'Admin\ProjectController@EditViolation'], $all_users))->name('edit.violation');
Route::put('update-violation', array_merge(['uses' => 'Admin\ProjectController@UpadteViolation'], $all_users))->name('update.violation');
Route::delete('delete-violation', array_merge(['uses' => 'Admin\ProjectController@deleteViolation'], $all_users))->name('delete.violation');
Route::delete('delete-objection', array_merge(['uses' => 'Admin\ProjectController@deleteObjection'], $all_users))->name('delete.objection');
/* * ****** End violation ********** */

/* * ******  confirmation Start ********** */
Route::get('list-confirmations/{violation_id}/', array_merge(['uses' => 'Admin\ProjectController@indexConfirmations'], $all_users))->name('list.confirmations');
Route::get('fetch-admin-data-confirmations', array_merge(['uses' => 'Admin\ProjectController@fetchConfirmationData'], $all_users))->name('fetch.admin.data.confirmations');
Route::delete('delete-confirmation', array_merge(['uses' => 'Admin\ProjectController@deleteconfirmation'], $all_users))->name('delete.confirmation');
Route::get('create-violation-confirmation/{violation_id}', array_merge(['uses' => 'Admin\ProjectController@CreateViolationConfrmation'], $all_users))->name('create.violation.confirmation');
Route::post('store-violation-confirmation', array_merge(['uses' => 'Admin\ProjectController@StoreViolationConfirmation'], $all_users))->name('store.violation.confirmation');
Route::get('edit-violation-confirmation/{id}', array_merge(['uses' => 'Admin\ProjectController@EditViolationConfirmation'], $all_users))->name('edit.violation.confirmation');
Route::put('update-violation-confirmation', array_merge(['uses' => 'Admin\ProjectController@UpadteViolationConfirmation'], $all_users))->name('update.violation.confirmation');
/* * ****** End confirmation ********** */

/* * ******  Evaluation Start ********** */
Route::get('list-evaluations/{project_id}/', array_merge(['uses' => 'Admin\ProjectController@indexEvaluation'], $all_users))->name('list.Evaluations');
Route::get('fetch-admin-data-evaluations', array_merge(['uses' => 'Admin\ProjectController@fetchEvaluationsData'], $all_users))->name('fetch.admin.data.evaluations');
Route::get('create-evaluation/{project_id}', array_merge(['uses' => 'Admin\ProjectController@CreateEvaluation'], $all_users))->name('create.evaluation');
Route::post('store-evaluation', array_merge(['uses' => 'Admin\ProjectController@StoreEvaluation'], $all_users))->name('store.evaluation');
Route::get('edit-evaluation/{id}', array_merge(['uses' => 'Admin\ProjectController@EditEvaluation'], $all_users))->name('edit.evaluation');
Route::put('update-evaluation', array_merge(['uses' => 'Admin\ProjectController@UpadteEvaluation'], $all_users))->name('update.evaluation');

Route::delete('delete-evaluation', array_merge(['uses' => 'Admin\ProjectController@deleteEvaluation'], $all_users))->name('delete.evaluation');
/* * ******  Evaluation End ********** */

/* *******  Studies Start ********** */
Route::get('list-studies/{project_id}/', array_merge(['uses' => 'Admin\ProjectController@indexStudies'], $all_users))->name('list.studies');
Route::get('fetch-admin-data-studies', array_merge(['uses' => 'Admin\ProjectController@fetchStudiesData'], $all_users))->name('fetch.admin.data.studies');
Route::delete('delete-studies', array_merge(['uses' => 'Admin\ProjectController@deleteStudy'], $all_users))->name('delete.studies');
Route::get('create-studies/{project_id}',array_merge(['uses' => 'Admin\ProjectController@CreateStudy'], $all_users))->name('add.studies');
Route::post('store-studies',array_merge(['uses' => 'Admin\ProjectController@StoreStudy'], $all_users))->name('store.studies');
/* *******  Studies End ********** */
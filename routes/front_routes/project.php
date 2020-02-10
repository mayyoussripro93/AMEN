<?php

Route::group(['middleware'=> ['auth:employee','can:amen-state-admin']], function()
{
    Route::get('create-project-form', 'ProjectController@CreateProjectGet')->name('create.project.form');
    Route::post('create-project-post', 'ProjectController@store')->name('create.project.add');
    Route::get('project_edit/{id}','ProjectController@edit')->name('project.edit');
    Route::post('project_update','ProjectController@update')->name('project.update');

    Route::get('projects.for.evaluation', 'ProjectController@ProjectForEvaluation')->name('projects.for.evaluation');
    Route::get('project.staff.evaluation/{id}/{yearmonth?}','ProjectController@ProjectEvaluationPage')->name('project.staff.evaluation');
    Route::post('project.evaluation.post','ProjectController@ProjectEvaluationStore')->name('project.evaluation.post');
    Route::post('project.staff.evaluation_fetch','ProjectController@ProjectEvaluationFetch')->name('project.staff.evaluation_fetch');
    Route::get('fetch-projects-for-evaluation', 'ProjectController@fetchProjectsDataForEvaluation')->name('fetch.data.projects.for.evaluation');
    Route::post('add_violation_cost','ProjectController@add_violation_cost')->name('project.violation.CostValue');


});

Route::group(['middleware'=> ['auth:employee']], function()
{
    Route::get('fetch-violations', 'ProjectController@fetchViolationsData')->name('fetch.data.violations');
    Route::get('fetch-projects', 'ProjectController@fetchProjectsData')->name('fetch.data.projects');

    Route::get('fetch-project-studies', 'ProjectController@fetchProjectStudies')->name('fetch.data.project.studies');
    Route::post('fetch-latitudelongtiude','ProjectController@fetchlatitudelongtiude')->name('fetch.city.latlong');

    Route::get('download_s3','ProjectController@DownloadFiles')->name('download_s3');

    Route::post('generate.pdf.Projects','ProjectController@GeneratePdfProjects')->name('generate.pdf.Projects');
    Route::post('generate-pdf.violations','ProjectController@GeneratePdfViolations')->name('generate.pdf.violations');
    Route::post('generate-pdf.violation','ProjectController@GeneratePdfOneViolation')->name('generate.pdf.violation');
    Route::post('generate-pdf.Invoice','ProjectController@GeneratePdfInvoice')->name('generate.pdf.Invoice');
    Route::post('generate.pdf.evaluations','ProjectController@GeneratePdfEvaluation')->name('generate.pdf.evaluations');
    Route::get('project_detail/{id}','ProjectController@show')->name('project.detail');
    Route::get('project_violations/{id}','ProjectController@show_violations')->name('project.project_violations');
    Route::get('project_violation_detail/{id1}/{id2}','ProjectController@violation_details')->name('project.violation.detail');
    Route::get('project_studies/{id}','ProjectController@ShowStudyUploads')->name('project.studies');
    Route::get('projects-show', 'ProjectController@index')->name('project.projects');
    Route::post('project_violation_comment_store','ProjectController@violation_comment_store' )->name('project.violation.comment.post');
    Route::post('project_violation_confirm','ProjectController@violation_confirm_store')->name('project.violation.confirm.post');
    Route::post('project_violation_object','ProjectController@violation_object_store')->name('project.violation.object.post');
    Route::post('project_violation_object_reply','ProjectController@violation_object_reply' )->name('project.violation.object_reply.post');

});

Route::group(['middleware'=> ['auth:employee','can:safety-consultant']], function()
{

    Route::get('add_violation/{id}', 'ProjectController@add_violation')->name('project.add_violation');
    Route::post('add-violation-post', 'ProjectController@store_violation')->name('project.store_violation');
    Route::post('change_payment_violation','ProjectController@change_payment_violation')->name('project.violation.payment');
});
Route::group(['middleware'=> ['auth:employee','can:project-consultant','can:safety-consultant']], function()
{
    Route::post('project-study-uploads','ProjectController@StudyUploads')->name('project.upload.study');
    Route::DELETE('delete-studies', 'ProjectController@deleteStudy')->name('front.delete.studies');

});











Route::get('areas', function(){return view('projects.areas');})->name('project.areas');
Route::get('project_report', function(){return view('projects.project_report');})->name('project.report');

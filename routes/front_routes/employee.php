<?php
Route::group(['middleware'=> ['auth:employee']], function()
{
    Route::get('employee-home', 'Employee\EmployeeController@index')->name('employee.home');
    Route::get('employee-employees', 'Employee\EmployeeController@EmployeesShow')->name('employee.employees');
    Route::get('employee-employees-fetch', 'Employee\EmployeeController@EmployeesShowFetch')->name('employee.employees.fetch');
    Route::get('employee-edit/{id}', 'Employee\EmployeeController@edit')->name('employee.edit1');
    Route::get('employee-show/{id}', 'Employee\EmployeeController@show')->name('employee.show');
    Route::put('employee-edit', 'Employee\EmployeeController@update')->name('employee.edit');
    Route::get('posted-initiatives', 'Employee\EmployeeController@postedInitiatives')->name('posted.Initiatives');
    Route::get('employee-delete-account', function(){return view('employee.account-deletion');})->name('delete.account');
    Route::post('delete.account.post','Employee\EmployeeController@Delete_Account')->name('delete.account.post');
    Route::get('report-abuse-company', 'ContactController@reportAbuseCompany')->name('report.abuse.company');
    Route::post('report-abuse-company', 'ContactController@reportAbuseCompanyPost')->name('report.abuse.company');
    Route::get('report-abuse-company-thanks', 'ContactController@reportAbuseCompanyThanks')->name('report.abuse.company.thanks');

    Route::get('employee-messages', 'Employee\EmployeeController@employeeMessages')->name('employee.messages');
    Route::get('employee-message-detail/{id}', 'Employee\EmployeeController@employeeMessageDetail')->name('employee.message.detail');
    Route::post('contact-employee-message-send', 'Employee\EmployeeController@sendContactForm')->name('contact.employee.message.send');
    Route::post('contact-applicant-message-send', 'Employee\EmployeeController@sendApplicantContactForm')->name('contact.applicant.message.send');
    Route::post('filter-lang-employee-dropdown', 'Employee\EmployeeController@filterLangStates')->name('filter.lang.employee.dropdown');

    Route::delete('delete-front-massage', 'Employee\EmployeeController@deleteMassage')->name('delete.front.massage');
    Route::get('employee-contacts', 'Employee\EmployeeController@employeeContacts')->name('employee.Contacts');
    Route::delete('delete-front-contacts', 'Employee\EmployeeController@deleteContacts')->name('delete.front.contacts');
    Route::delete('delete-front-massage-contacts', 'Employee\EmployeeController@deleteMassageContacts')->name('delete.front.massage.contacts');
    Route::post('send-mail-contacts',
        ['uses' => 'Employee\EmployeeController@sendContactMail', 'as' => 'send.mail.contacts']);
    Route::post('add-mail-contacts',
        ['uses' => 'Employee\EmployeeController@addContactMail', 'as' => 'add.mail.contacts']);
    Route::get('employee-contacts-message-detail/{id}', 'Employee\EmployeeController@employeeContactsMessageDetail')->name('employee.contacts.message.detail');

    Route::get('employee.evaluation.show','Employee\EmployeeController@EvaluationShow')->name('employee.evaluation');
    Route::get('fetch.data.staff.evaluation','Employee\EmployeeController@EvaluationShowFetch')->name('fetch.data.staff.evaluation');

});

Route::group(['middleware'=> ['auth:employee','can:is_manager']], function()
{
    Route::get('employee-create', 'Employee\EmployeeController@create')->name('employee.add');
    Route::post('employee-create', 'Employee\EmployeeController@store')->name('employee.add');
});


Route::group(['middleware'=> ['auth:employee','can:amen-state-admin']], function()
{
    Route::get('new-employees-view', 'Employee\EmployeeController@get_new_registers')->name('new-employees-view');
    Route::get('one-employee-view/{id}', 'Employee\EmployeeController@get_one_register')->name('one-employee-view');
    Route::post('new_register_verify','Employee\EmployeeController@verify_register')->name('new_register_verify');
    Route::get('employee-evaluate-create', 'Employee\EmployeeController@Evaluate_Create')->name('employee.evaluate.create');
    Route::get('employee.evaluation.all','Employee\EmployeeController@EvaluationShowAll')->name('employee.evaluation.all');
    Route::get('fetch.data.allstaff.evaluation','Employee\EmployeeController@EvaluationShowFetchAll')->name('fetch.data.allstaff.evaluation');

});



Route::get('employee-account-activation', function(){return view('employee.account-activation');})->name('account-activation');



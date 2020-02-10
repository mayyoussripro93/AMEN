<?php

/* * ******  Job Start ********** */

Route::post('employee-Project-admin', array_merge(['uses' => 'Admin\EventController@employeeProject'], $all_users))->name('employee.Project.admin');

/* * ****** End Job ********** */
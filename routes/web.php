<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
$real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'front_routes' . DIRECTORY_SEPARATOR;
/* * ******** IndexController ************ */
Route::get('/', 'IndexController@index')->name('index');


Route::post('set-locale', 'IndexController@setLocale')->name('set.locale');
/* * ******** HomeController ************ */
Route::get('home', 'HomeController@index')->name('home');
/* * ******** TypeAheadController ******* */
Route::get('typeahead-currency_codes', 'TypeAheadController@typeAheadCurrencyCodes')->name('typeahead.currency_codes');
/* * ******** FaqController ******* */
Route::get('faq', 'FaqController@index')->name('faq');
/* * ******** CronController ******* */
Route::get('check-package-validity', 'CronController@checkPackageValidity');
/* * ******** Verification ******* */
Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');
Route::get('company-email-verification/error', 'Company\Auth\RegisterController@getVerificationError')->name('company.email-verification.error');
Route::get('company-email-verification/check/{token}', 'Company\Auth\RegisterController@getVerification')->name('company.email-verification.check');


/* * ***************************** */
// Sociallite Start
// OAuth Routes
Route::get('login/jobseeker/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/jobseeker/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('login/employer/{provider}', 'Company\Auth\LoginController@redirectToProvider');
Route::get('login/employer/{provider}/callback', 'Company\Auth\LoginController@handleProviderCallback');
// Sociallite End
/* * ***************************** */
Route::post('tinymce-image_upload-front', 'TinyMceController@uploadImage')->name('tinymce.image_upload.front');

Route::post('subscribe-newsletter', 'SubscriptionController@getSubscription')->name('subscribe.newsletter');

Route::get('safety-gallery','IndexController@SafetyGallery')->name('safety.gallery');
Route::get('images-gallery','IndexController@ImagesGallery')->name('images.gallery');

Route::get('contact-us',function(){return view('includes.contact_us');})->name('contact.us');
Route::get('tech_support',function(){return view('includes.tech_support');})->name('tech.support');
Route::get('terms-conditions',function(){return view('includes.terms-conditions');})->name('terms-conditions');

Route::get('account-activation/{token}','IndexController@get_activate_register' )->where('token', '(.*)')->name('get.account-activation');
Route::post('employee-account-activation', 'IndexController@post_activate_register')->name('post.account-activation');


Route::get('events_create', 'EventController@index')->name('events.index');
Route::post('events', 'EventController@addEvent')->name('events.add');
Route::post('filter/initiatives', 'IndexController@filterInitiatives')->name('filter.initiatives');
Route::resource('appointments', 'Admin\AppointmentsController');
Route::post('appointments_ajax_update',
    ['uses' => 'EventController@ajaxUpdate', 'as' => 'appointments.ajax_update']);
Route::post('appointments_ajax_delete',
    ['uses' => 'EventController@ajaxDelete', 'as' => 'appointments.ajax_delete']);
Route::get('events-users', 'EventController@userIndex')->name('events.user.index');
/* * ******** OrderController ************ */
include_once($real_path . 'order.php');
/* * ******** CmsController ************ */
include_once($real_path . 'cms.php');
/* * ******** JobController ************ */
include_once($real_path . 'job.php');
/* * ******** ContactController ************ */
include_once($real_path . 'contact.php');
/* * ******** CompanyController ************ */
include_once($real_path . 'company.php');
/* * ******** EmployeeController ************ */
include_once($real_path . 'employee.php');
/* * ******** InitiativesController ************ */
include_once($real_path . 'Initiatives.php');
/* * ******** ProjectController ************ */
include_once($real_path . 'project.php');
/* * ******** AjaxController ************ */
include_once($real_path . 'ajax.php');
/* * ******** UserController ************ */
include_once($real_path . 'site_user.php');
/* * ******** User Auth ************ */
//Auth::routes();
/* * ******** Employee Auth ************ */
include_once($real_path . 'employee_auth.php');
/* * ******** Company Auth ************ */
include_once($real_path . 'company_auth.php');
/* * ******** Admin Auth ************ */
include_once($real_path . 'admin_auth.php');

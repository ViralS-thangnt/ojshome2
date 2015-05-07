<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/http://ojs.app/admin/editor-manuscript/form/259
//Homepage
Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
Route::get('book', 'BooksController@index');
//User management
Route::get('admin/user/form/{id?}', 'Admin\UsersController@form');
Route::post('admin/user/form/{id?}', ['uses' => 'Admin\UsersController@update', 'as' => 'user.update']);
Route::resource('admin/user', 'Admin\UsersController', ['except' => ['create', 'edit', 'store', 'show', 'update']]);
// Route::get('admin/user/destroy/{id}', ['uses' => 'Admin\UsersController@destroy', 'as' => 'user.destroy']);

//Journal management
//Route::resource('admin/journal', 'JournalsController', ['except' => ['create', 'edit', 'store', 'show', 'update']]);
Route::get('admin/journal/form/{id?}' , 'JournalsController@form');
Route::post('admin/journal/form/{id?}', ['uses' => 'JournalsController@update', 'as' =>'journal.update']);
Route::get('admin/journal/{id}/position/{ms_id}/{order?}', 'JournalsController@position');
Route::get('admin/journal/{id}/{ms_id}/remove', 'JournalsController@removeManuscript');
Route::get('admin/journal/{id}/{ms_id}/add', 'JournalsController@addManuscript');
Route::get('admin/journal', ['as' =>'journal.all', 'uses' => 'JournalsController@index' ]);


Route::get('admin/journal/unpublish', ['as' =>'journal.unpublish', 'uses' => 'JournalsController@unpublish']);
Route::get('admin/journal/published', ['as' =>'journal.published', 'uses' => 'JournalsController@published']);

Route::get('admin/journal/{id}/detail', ['as' =>'journal.detail', 'uses' => 'JournalsController@show']);
Route::get('admin/journal/destroy/{id}', ['as' =>'journal.destroy', 'uses' => 'JournalsController@destroy']);

// Keyword
Route::resource('admin/keyword', 'KeywordsController', ['except' => ['create', 'edit', 'store', 'show', ' update']]);
Route::get('admin/keyword/form/{id?}', 'KeywordsController@form');
Route::post('admin/keyword/form/{id?}', ['uses' => 'KeywordsController@update', 'as' =>'keyword.update']);

//Authenticate User
Route::controllers([
    'user' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Dashboard
Route::get('admin', ['as'   =>  'dashboard', 'uses' =>  'Admin\DashboardController@index']);
Route::get('admin/user-dashboard', ['as'    =>  'dashboard.user',
                                    'uses'    =>  'Admin\DashboardController@userDashboard']);
// Route::post('admin/setLocale', ['as'    =>  'admin.setLocale', 'uses'   =>  'Admin\DashboardController@setLocale']);
Route::get('admin/setLocale', ['as'    =>  'admin.setLocale', 'uses'   =>  'Admin\DashboardController@setLocale']);


//Manuscript Links
Route::get(Constant::$url['manuscript.form'], ['as'  =>  'manuscript.form', 'uses'   =>  'Admin\ManuscriptsController@form']);
Route::post(Constant::$url['manuscript.update'], ['as' =>  'manuscript.update', 'uses'  =>  'Admin\ManuscriptsController@update']);
Route::post(Constant::$url['manuscript.insert'], ['as' =>  'manuscript.insert', 'uses'  =>  'Admin\ManuscriptsController@insert']);
Route::post(Constant::$url['manuscript.withdrawn'] . '/{id}', ['as' =>  'manuscript.withdrawn', 'uses'  =>  'Admin\ManuscriptsController@withdrawnManuscript']);

Route::get(Constant::$url['unsubmit'],    ['uses' => 'Admin\ManuscriptsController@unsubmit']);
Route::get(Constant::$url['in-screening'], ['uses' => 'Admin\ManuscriptsController@inScreening']);
Route::get(Constant::$url['in-review'],    ['uses' => 'Admin\ManuscriptsController@inReview']);
Route::get(Constant::$url['in-editing'],   ['uses' => 'Admin\ManuscriptsController@inEditing']);
Route::get(Constant::$url['rejected'],    ['uses' => 'Admin\ManuscriptsController@rejected']);
Route::get(Constant::$url['withdrawn'],   ['uses' => 'Admin\ManuscriptsController@withdrawn']);
Route::get(Constant::$url['published'],   ['uses' => 'Admin\ManuscriptsController@published']);
Route::get(Constant::$url['reviewed'],  ['uses' => 'Admin\ManuscriptsController@reviewed']);
Route::get(Constant::$url['wait-review'],  ['uses' => 'Admin\ManuscriptsController@waitReview']);
Route::get(Constant::$url['rejected-review'], ['uses' => 'Admin\ManuscriptsController@rejectedReview']);
Route::get(Constant::$url['all'],  ['uses' => 'Admin\ManuscriptsController@all']);

Route::get(Constant::$url['get_all'],  ['uses' => 'Admin\ManuscriptsController@getall']);
Route::post(Constant::$url['get_all'],  ['uses' => 'Admin\ManuscriptsController@SoftDeletes']);

Route::get(Constant::$url['report-rejected'],  ['uses' => 'Admin\ReportsController@showReportRejected']);
Route::post(Constant::$url['report-rejected'], ['uses'	=>	'Admin\ReportsController@showReportRejected']);

Route::get(Constant::$url['report-submited'],  ['uses' => 'Admin\ReportsController@showReportSubmited']);
Route::post(Constant::$url['report-submited'],  ['uses' => 'Admin\ReportsController@showReportSubmited']);

Route::get(Constant::$url['report-publish-in-year'],  ['uses' => 'Admin\ReportsController@showReportPublishInYear']);
Route::post(Constant::$url['report-publish-in-year'],  ['uses' => 'Admin\ReportsController@showReportPublishInYear']);

Route::get(Constant::$url['report-review-loop'],  ['uses' => 'Admin\ReportsController@showReportReviewLoop']);
Route::post(Constant::$url['report-review-loop'],  ['uses' => 'Admin\ReportsController@showReportReviewLoop']);

Route::get(Constant::$url['report-withdrawn'],  ['uses' => 'Admin\ReportsController@showReportWithdrawn']);
Route::post(Constant::$url['report-withdrawn'],  ['uses' => 'Admin\ReportsController@showReportWithdrawn']);

Route::get(Constant::$url['report-ratio-reject'],  ['uses' => 'Admin\ReportsController@showReportRatioReject']);
Route::post(Constant::$url['report-ratio-reject'],  ['uses' => 'Admin\ReportsController@showReportRatioReject']);

Route::get(Constant::$url['report-published-delinquent'],  ['uses' => 'Admin\ReportsController@showReportPublishedDelinquent']);
Route::post(Constant::$url['report-published-delinquent'],  ['uses' => 'Admin\ReportsController@showReportPublishedDelinquent']);

Route::get(Constant::$url['report-journal-in-year'],  ['uses' => 'Admin\ReportsController@showReportJournalInYear']);
Route::post(Constant::$url['report-journal-in-year'],  ['uses' => 'Admin\ReportsController@showReportJournalInYear']);

Route::get(Constant::$url['report-review-time'],  ['uses' => 'Admin\ReportsController@showReportReviewTime']);
Route::post(Constant::$url['report-review-time'],  ['uses' => 'Admin\ReportsController@showReportReviewTime']);

Route::get(Constant::$url['editor.manuscript.form'], ['uses' => 'Admin\EditorManuscriptsController@form']);

Route::post(Constant::$url['editor.manuscript.form'], ['uses' => 'Admin\EditorManuscriptsController@update', 'as' => 'editor.manuscript.update']);
Route::post(Constant::$url['editor.manuscript.update'], ['uses' => 'Admin\EditorManuscriptsController@update', 'as' => 'editor.manuscript.update']);
Route::post(Constant::$url['editor.manuscript.update-editor'], ['uses' => 'Admin\EditorManuscriptsController@update', 'as' => 'editor.manuscript.update-editor']);

//ajax
Route::post('manuscript-update', ['uses' => 'Admin\EditorManuscriptsController@ajaxUpdate']);

// download file 
Route::get(Constant::$url['download-file'] . '{manu_file_id}',  ['uses' => 'Admin\ManuscriptsController@downloadFileEditor']);

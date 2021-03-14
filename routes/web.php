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
//Static pages
Route::get('/', 'Frontend\MainController@index')->name('home');
Route::get('/o-proekte', function(){
    return view('frontend.pages.about');
});
Route::get('/develope', function(){
    return view('frontend.develope');
})->name('dev');

Route::get('/fond/{id}', 'Frontend\FondController@fond')->name('innerFond');
Route::get('/about', 'Frontend\MainController@about')->name('about');
Route::get('/contacts', 'Frontend\MainController@contacts')->name('contacts');
Route::get('/question-answer', 'Frontend\MainController@qa')->name('qa');
Route::get('/helps', 'Frontend\MainController@helps')->name('helps');
Route::get('/help/{id}', 'Frontend\MainController@help')->name('help');
Route::get('/reviews', 'Frontend\MainController@reviews')->name('allreviews');
Route::get('/fonds', 'Frontend\FondController@fonds')->name('fonds');
Route::get('/news', 'Frontend\MainController@news')->name('news');
Route::get('/news/{slug}', 'Frontend\MainController@new')->name('new');

//User Auth
Route::get('login-user', 'UserAuthController@index')->name('login');
Route::post('post-login-user', 'UserAuthController@postLogin')->name('post_login_user');
Route::get('registration_user', 'UserAuthController@registration')->name('registration_user');
Route::post('post-registration-user', 'UserAuthController@postRegistration')->name('post_registration_user');

//Fond Auth
Route::post('post-login-fond', 'FondAuthController@postLogin')->name('post_login_fond');
Route::get('registration_fond', 'FondAuthController@registration')->name('registration_fond');
Route::post('post-registration-fond', 'FondAuthController@postRegistration')->name('post_registration_fond');

//Admin Auth
Route::get('admin-login', 'AdminAuthController@index')->name('admin_login');


Route::group(['prefix'=>'/admin','middleware'=>['admin']], function(){
    Route::get('/', 'Backend\AdminController@index');
});

Route::group(['middleware'=>['auth:fond','check.fond.status']], function(){
    Route::get('/cabinet/fond', 'Backend\FondController@index')->name('fond_cabinet');
    Route::get('/cabinet/fond/edit', 'Backend\FondController@edit')->name('fond_setting');
    Route::get('/cabinet/fond/projects', 'Backend\FondController@projects')->name('fond_projects');
    Route::post('/cabinet/fond/edit', 'Backend\FondController@update')->name('fond_setting');
    Route::match(['get','post'], '/cabinet/fond/projects', 'Backend\FondController@projects')->name('projects');
    Route::match(['get','post'], '/cabinet/fond/create_project', 'Backend\FondController@create_project')->name('create_project');
    Route::delete('/cabinet/fond/delete_partner', 'Backend\FondController@delete_partner')->name('delete_partner');
    Route::match(['get','post'], '/cabinet/fond/partners', 'Backend\FondController@partners')->name('partners');
    Route::match(['get','post'], '/cabinet/fond/gallery', 'Backend\FondController@gallery')->name('gallery');
    Route::post('/cabinet/fond/help-start/{id}', 'Backend\FondController@start_help')->name('start_help');
    Route::post('/cabinet/fond/help-finish/{id}', 'Backend\FondController@finish_help')->name('finish_help');
    Route::get('logout-fond', 'FondAuthController@logout')->name('logout_fond');
});

//Auth::routes();
Route::group(['middleware'=>'auth'], function(){
    Route::get('cabinet', 'Backend\CabinetController@index')->name('cabinet');
    Route::get('cabinet/{id}/edit', 'Backend\CabinetController@editUser')->name('editUser');
    Route::post('fond/help', 'Backend\CabinetController@help')->name('helpfond');
    Route::post('review', 'Backend\CabinetController@review_to_fond')->name('review_to_fond');
    Route::get('cabinet/reviews', 'Backend\CabinetController@reviews')->name('reviews');
    Route::get('cabinet/helps', 'Backend\CabinetController@helpsHistory')->name('history');
    Route::get('logout-user', 'UserAuthController@logout')->name('logout_user');
});

<?php

//Static pages
Route::get('/', 'Frontend\MainController@index')->name('home');
Route::get('/o-proekte', function(){
    return view('frontend.pages.about');
});
Route::get('/develope', function(){
    return view('frontend.develope');
})->name('dev');

Route::get('/fond/{id}', 'Frontend\FondController@fond')->name('innerFond');
Route::get('/fond/donation/{id}', 'Frontend\FondController@donationToFond')->name('donation_to_fond');
Route::get('/about', 'Frontend\MainController@about')->name('about');
Route::get('/contacts', 'Frontend\MainController@contacts')->name('contacts');
Route::get('/question-answer', 'Frontend\MainController@qa')->name('qa');
Route::get('/helps', 'Frontend\MainController@helps')->name('helps');
Route::get('/help/{id}', 'Frontend\MainController@helpPage')->name('help');
Route::get('/help-page', 'Frontend\MainController@help')->name('help-page');
Route::get('/reviews', 'Frontend\MainController@reviews')->name('allreviews');
Route::get('/fonds', 'Frontend\FondController@fonds')->name('fonds');
Route::get('/news', 'Frontend\MainController@news')->name('news');
Route::get('/news/{slug}', 'Frontend\MainController@new')->name('new');

//User Auth
Route::get('login-user', 'UserAuthController@index')->name('login');
Route::post('post-login-user', 'UserAuthController@postLogin')->name('post_login_user');
Route::get('registration_user', 'UserAuthController@registration')->name('registration_user');
Route::post('post-registration-user', 'UserAuthController@postRegistration')->name('post_registration_user');
Route::post('post_sms_user', 'UserAuthController@postSmsRegistration')->name('post_sms_user');

//Fond Auth
Route::get('login-fond', 'FondAuthController@index')->name('login-fond');
Route::post('post-login-fond', 'FondAuthController@postLogin')->name('post_login_fond');
Route::get('registration_fond', 'FondAuthController@registration')->name('registration_fond');
Route::post('post-registration-fond', 'FondAuthController@postRegistration')->name('post_registration_fond');

//Admin Auth
Route::get('admin-login', 'AdminAuthController@index')->name('admin_login');
Route::post('admin-post-login', 'AdminAuthController@postLogin')->name('admin_post_login');

Route::group(['prefix'=>'/admin','middleware'=>['auth:admin']], function(){
    Route::get('/', 'Backend\AdminController@index')->name('admin_home');
    Route::get('/admin-helps', 'Backend\AdminController@showHelps')->name('admin_helps');
    Route::get('/admin-help/{id}/check', 'Backend\AdminController@checkHelp')->name('admin_help_check');
    Route::post('/edit-help-status', 'Backend\AdminController@editHelpStatus')->name('edit_help_status');
    Route::get('logout-admin', 'AdminAuthController@logout')->name('logout_admin');
    Route::get('admins', 'Backend\AdminUserController@index')->name('admins');
    Route::get('admins/{id}/edit', 'Backend\AdminUserController@edit')->name('admins_edit');
    Route::post('admins/{id}/update', 'Backend\AdminUserController@update')->name('admins_update');
    Route::post('admins/{id}/destroy', 'Backend\AdminUserController@destroy')->name('admins_delete');
});

Route::group(['middleware'=>['auth:fond','check.fond.status']], function(){
    Route::get('/cabinet/fond', 'Backend\FondController@index')->name('fond_cabinet');
    Route::get('/cabinet/fond/edit', 'Backend\FondController@edit')->name('fond_setting');
    Route::match(['get','post'], '/cabinet/fond/edit-activity', 'Backend\FondController@editActivity')->name('fond_editActivity');
    Route::get('/cabinet/fond/projects', 'Backend\FondController@projects')->name('fond_projects');
    Route::post('/cabinet/fond/edit', 'Backend\FondController@update')->name('fond_setting');
    Route::match(['get','post'], '/cabinet/fond/projects', 'Backend\FondController@projects')->name('projects');
    Route::match(['get','post'], '/cabinet/fond/create_project', 'Backend\FondController@create_project')->name('create_project');
    Route::delete('/cabinet/fond/delete_partner', 'Backend\FondController@delete_partner')->name('delete_partner');
    Route::match(['get','post'], '/cabinet/fond/partners', 'Backend\FondController@partners')->name('partners');
    Route::match(['get','post'], '/cabinet/fond/gallery', 'Backend\FondController@gallery')->name('gallery');
    Route::delete('/cabinet/fond/gallery', 'Backend\FondController@delete_gallery')->name('delete_gallery');
    Route::post('/cabinet/fond/help-start/{id}', 'Backend\FondController@start_help')->name('start_help');
    Route::post('/cabinet/fond/help-finish/{id}', 'Backend\FondController@finish_help')->name('finish_help');
    Route::get('/cabinet/fond/help-page/{id}', 'Backend\FondController@helpPage')->name('fond_help_page');
    Route::get('logout-fond', 'FondAuthController@logout')->name('logout_fond');
});

//Auth::routes();
Route::group(['middleware'=>'auth'], function(){
    Route::match(['get','post'], 'request-for-help', 'Frontend\FondController@request_help')->name('request_help');
    Route::get('cabinet/{id}/edit', 'Backend\CabinetController@editUser')->name('editUser');
    Route::post('cabinet/{id}/edit', 'Backend\CabinetController@updateHelp')->name('update_help');
    Route::get('cabinet', 'Backend\CabinetController@index')->name('cabinet');
    Route::post('fond/help', 'Backend\CabinetController@help')->name('helpfond');
    Route::post('review', 'Backend\CabinetController@review_to_fond')->name('review_to_fond');
    Route::get('cabinet/reviews', 'Backend\CabinetController@reviews')->name('reviews');
    Route::get('cabinet/helps', 'Backend\CabinetController@helpsHistory')->name('history');
    Route::get('cabinet/help-page/{id}', 'Backend\CabinetController@helpPage')->name('cabinet_help_page');
    Route::get('cabinet/edit-page/{id}', 'Backend\CabinetController@editPage')->name('cabinet_edit_page');
    Route::get('logout-user', 'UserAuthController@logout')->name('logout_user');
});

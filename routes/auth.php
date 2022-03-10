<?php

//User Auth
Route::get('/check_user', 'UserAuthController@checkUser')->name('check_user'); // idp
Route::get('login-user', 'UserAuthController@index')->name('login');
//Route::post('post-login-user', 'UserAuthController@postLogin')->name('post_login_user');
Route::get('registration_user', 'UserAuthController@registration')->name('registration_user'); // redirect to idp
Route::get('dev-auth', 'UserAuthController@userDevAuth')->name('user_dev_auth')->middleware('throttle:10,1');
//Route::post('post-registration-user', 'UserAuthController@postRegistration')->name('post_registration_user');
//Route::post('post_sms_user', 'UserAuthController@postSmsRegistration')->name('post_sms_user');

//Fond Auth
Route::get('login-fond', 'FondAuthController@index')->name('login-fond');
Route::post('post-login-fond', 'FondAuthController@postLogin')->name('post_login_fond')->middleware('throttle:3,5');
Route::get('registration_fond', 'FondAuthController@registration')->name('registration_fond');
Route::post('post-registration-fond', 'FondAuthController@postRegistration')->name('post_registration_fond')->middleware('throttle:3,5');

//Admin Auth
Route::get('admin-login', 'AdminAuthController@index')->name('admin_login');
Route::post('admin-post-login', 'AdminAuthController@postLogin')->name('admin_post_login')->middleware('throttle:3,5');

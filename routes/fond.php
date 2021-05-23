<?php

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
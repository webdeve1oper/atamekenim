<?php

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
    Route::match(['get','post'], '/create', 'Backend\AdminUserController@create')->name('admin_create');
    Route::get('/admin-fonds', 'Backend\AdminController@showFonds')->name('admin_fonds');
    Route::get('/admin-helps/{category}', 'Backend\AdminController@showHelpsFromCategory')->name('admin_helps_category');
    Route::get('/admin-fonds/{category}', 'Backend\AdminController@showFondsFromCategory')->name('admin_fonds_category');
    Route::get('/admin-fond/{id}/check', 'Backend\AdminController@checkFond')->name('admin_fond_check');
    Route::post('/edit-fond-status', 'Backend\AdminController@editFondStatus')->name('edit_fond_status');
    Route::post('/update_help_from_admin/{id}', 'Backend\AdminController@editHelpBodyFromAdmin')->name('update_help_from_admin');

    Route::get('news', 'Backend\AdminNewsController@index')->name('admin_news');
    Route::get('news/{id}/edit', 'Backend\AdminNewsController@edit')->name('admin_news_edit');
    Route::post('news/{id}/update', 'Backend\AdminNewsController@update')->name('admin_news_update');
    Route::match(['get','post'], 'news/create', 'Backend\AdminNewsController@create')->name('admin_news_create');
    Route::post('news/{id}/destroy', 'Backend\AdminNewsController@destroy')->name('admin_news_delete');

    Route::get('/active-fonds', 'Backend\AdminController@activeFonds')->name('active_fonds');
    Route::get('/active-fonds/{id}/check', 'Backend\AdminController@checkActiveFond')->name('active_fond_check');
    Route::post('/active-fonds/{id}/edit', 'Backend\AdminController@editActiveFond')->name('active_fond_edit');
    Route::match(['GET', 'POST'], '/active-export', 'ExcelController@exportXls')->name('admin_export');
});

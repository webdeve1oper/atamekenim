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
    Route::get('/admin-fonds', 'Backend\AdminController@showFonds')->name('admin_fonds');
    Route::get('/admin-helps/{category}', 'Backend\AdminController@showHelpsFromCategory')->name('admin_helps_category');
    Route::get('/admin-fonds/{category}', 'Backend\AdminController@showFondsFromCategory')->name('admin_fonds_category');
});

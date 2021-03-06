<?php

Route::group(['middleware'=>['auth:fond','check.fond.status', 'throttle:100,1']], function(){
    Route::get('/cabinet/fond', 'Backend\FondController@index')->name('fond_cabinet');
    Route::post('/cabinet/fond/requisite/create', 'Backend\FondController@requisiteCreate')->name('requisite_create');
    Route::post('/cabinet/fond/requisite/edit/{id}', 'Backend\FondController@requisiteEdit')->name('requisite_edit');
    Route::post('/cabinet/fond/requisite/delete/{id}', 'Backend\FondController@requisiteDelete')->name('requisite_delete');
    Route::post('/cabinet/fond/office/create', 'Backend\FondController@officeCreate')->name('office_create');
    Route::post('/cabinet/fond/office/edit/{id}', 'Backend\FondController@officeEdit')->name('office_edit');
    Route::post('/cabinet/fond/office/delete/{id}', 'Backend\FondController@officeDelete')->name('office_delete');
    Route::get('/cabinet/fond/edit', 'Backend\FondController@edit')->name('fond_setting');
    Route::match(['get','post'], '/cabinet/fond/edit-activity', 'Backend\FondController@editActivity')->name('fond_editActivity');
    Route::get('/cabinet/fond/projects', 'Backend\ProjectController@projects')->name('fond_projects');
    Route::post('/cabinet/fond/edit', 'Backend\FondController@update')->name('fond_setting');
    Route::match(['get','post'], '/cabinet/fond/projects', 'Backend\ProjectController@projects')->name('projects');
    Route::match(['get','post'], '/cabinet/fond/create_project', 'Backend\ProjectController@createProject')->name('create_project');
    Route::get('/cabinet/fond/project-page/{id}', 'Backend\ProjectController@projectPage')->name('fond_project_page');
    Route::match(['get','post'], '/cabinet/fond/update-page/{id}', 'Backend\ProjectController@updatePage')->name('fond_project_update');
    Route::delete('/cabinet/fond/delete_partner', 'Backend\FondController@deletePartner')->name('delete_partner');
    Route::match(['get','post'], '/cabinet/fond/partners', 'Backend\Fond\FondPartnerController@partners')->name('partners');
    Route::post('/cabinet/fond/partners/update', 'Backend\Fond\FondPartnerController@updatePartner')->name('update_partner');
    Route::match(['get','post'], '/cabinet/fond/gallery', 'Backend\Fond\FondGalleryController@gallery')->name('gallery');
    Route::post('/cabinet/fond/gallery/update', 'Backend\Fond\FondGalleryController@updateGallery')->name('update_gallery');
    Route::delete('/cabinet/fond/gallery', 'Backend\FondController@deleteGallery')->name('delete_gallery');
    Route::post('/cabinet/fond/help-start/{id}', 'Backend\FondController@startHelp')->name('start_help');
    Route::post('/cabinet/fond/help-finish/{id}', 'Backend\FondController@finishHelp')->name('finish_help');
    Route::post('/cabinet/fond/help-cancel/{id}', 'Backend\FondController@cancelHelp')->name('cancel_help');
    Route::get('/cabinet/fond/help-page/{id}', 'Backend\FondController@helpPage')->name('fond_help_page');
    Route::get('logout-fond', 'FondAuthController@logout')->name('logout_fond');
});

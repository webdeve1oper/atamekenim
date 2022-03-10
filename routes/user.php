<?php
//Auth::routes();
//Route::get('logins', function(){return view('auth.login_iin');});
//Route::post('logins', 'UserAuthController@postLogin');
Route::group(['middleware'=>'auth'], function(){
    Route::match(['get','post'], 'request-for-help', 'Frontend\FondController@requestHelp')->name('request_help');
    Route::get('cabinet/edit', 'Backend\CabinetController@editUser')->name('editUser');
    Route::post('cabinet/update-info', 'Backend\CabinetController@updateUser')->name('updateUser')->middleware('throttle:10,1');
    Route::post('cabinet/{id}/edit', 'Frontend\FondController@requestHelp')->name('update_help')->middleware('throttle:10,1');
    Route::get('cabinet', 'Backend\CabinetController@index')->name('cabinet');
    Route::post('fond/help', 'Backend\CabinetController@help')->name('helpfond')->middleware('throttle:10,1');
    Route::post('review', 'Backend\CabinetController@review_to_fond')->name('review_to_fond')->middleware('throttle:10,1');
    Route::get('cabinet/reviews', 'Backend\CabinetController@reviews')->name('reviews');
    Route::get('cabinet/helps', 'Backend\CabinetController@helpsHistory')->name('history');
    Route::get('cabinet/help-page/{id}', 'Backend\CabinetController@helpPage')->name('cabinet_help_page');
    Route::get('cabinet/edit-page/{id}', 'Backend\CabinetController@editPage')->name('cabinet_edit_page');
    Route::get('cabinet/delete-image', 'Backend\CabinetController@deleteImage')->name('delete_help_image');
    Route::get('cabinet/delete-file', 'Backend\CabinetController@deleteFile')->name('delete_help_file');
    Route::get('logout-user', 'UserAuthController@logout')->name('logout_user');
});

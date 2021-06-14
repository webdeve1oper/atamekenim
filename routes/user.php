<?php

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
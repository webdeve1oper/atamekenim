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
Route::get('/project/{id}', 'Backend\ProjectController@index')->name('innerProject');
Route::post('/fond/donation', 'Frontend\FondController@donationToFond')->name('donation_to_fond');
Route::post('/fond/donation-recurrent', 'Frontend\FondController@cloudPaymentsDonation')->name('donation_cloudpayments_fond');
Route::get('/payment-success', function(){
    return view('payment.success');
})->name('success_payment');
Route::get('/about', 'Frontend\MainController@about')->name('about');
Route::get('/contacts', 'Frontend\MainController@contacts')->name('contacts');
Route::get('/question-answer', 'Frontend\MainController@qa')->name('qa');
Route::get('/helps', 'Frontend\HelpController@helps')->name('helps');
Route::get('/help/{id}', 'Frontend\MainController@helpPage')->name('help');
Route::get('/help-page', 'Frontend\MainController@help')->name('help-page');
Route::get('/reviews', 'Frontend\MainController@reviews')->name('allreviews');
Route::get('/fonds', 'Frontend\FondController@fonds')->name('fonds');
Route::get('/news', 'Frontend\MainController@news')->name('news');
Route::get('/news/{slug}', 'Frontend\MainController@new')->name('new');

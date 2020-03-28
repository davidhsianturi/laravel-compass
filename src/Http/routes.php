<?php

// Route request.
Route::get('/request', 'RequestController@index')->name('request');
Route::post('/request', 'RequestController@store')->name('request.store');
Route::get('/request/{id}', 'RequestController@show')->name('request.show');

// Route response.
Route::post('/response', 'ResponseController@store')->name('response.store');
Route::get('/response/{uuid}', 'ResponseController@show')->name('response.show');
Route::delete('/response/{uuid}', 'ResponseController@destroy')->name('response.destroy');

Route::get('/credentials', 'CredentialController')->name('credentials');

// Catch-all Route.
Route::get('/{view?}', 'HomeController')->where('view', '(.*)')->name('home');

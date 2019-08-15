<?php

// Routes.
Route::get('/routes', 'RoutesController@index')->name('routes');
Route::post('/routes', 'RoutesController@store')->name('routes.store');
Route::get('/routes/{id}', 'RoutesController@show')->name('routes.show');

// Catch-all Route.
Route::get('/{view?}', 'HomeController')->where('view', '(.*)')->name('home');

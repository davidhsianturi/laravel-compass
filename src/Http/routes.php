<?php

// Routes.
Route::get('/routes', 'RoutesController@index')->name('routes');
Route::post('/routes', 'RoutesController@store')->name('routes.store');
Route::get('/routes/{id}', 'RoutesController@show')->name('routes.show');
// Docs.
Route::post('/docs', 'DocsController@store')->name('docs.store');
Route::get('/docs/{uuid}', 'DocsController@show')->name('docs.show');
Route::delete('/docs/{uuid}', 'DocsController@destroy')->name('docs.destroy');

// Catch-all Route.
Route::get('/{view?}', 'HomeController')->where('view', '(.*)')->name('home');

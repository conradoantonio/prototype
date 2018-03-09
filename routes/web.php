<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#Root url
Route::get('/', function () {
	return auth()->check() ? redirect()->action('LoginController@dashboard') : view('login');
});

#Route url
Route::post('/login', 'LoginController@index');

#Admin url
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', 'LoginController@dashboard')->middleware('role:Administrador');

	#Faqs CRUD
	Route::middleware(['role:Administrador'])->prefix('faqs')->group(function () {
    	Route::get('/', 'FaqsController@index');
        Route::get('form/{$id}', 'FaqsController@form');
    	Route::post('save', 'FaqsController@save');
    	Route::post('update', 'FaqsController@update');
    	Route::post('delete', 'FaqsController@delete');
	});
    

    Route::get('users', 'UsersController@index')->middleware('role:Administrador');
});


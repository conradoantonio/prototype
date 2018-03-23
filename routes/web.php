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

#Login view
Route::get('login', function () {
    return view('login');
})->name('login');

#Logout url
Route::get('logout', 'LoginController@logout');

#Code created by Luis (Geno-sama), the leader of the first world!!!!!, he bring us peace for everyone... the real one majesty!
Route::get('test', function(){
    event(new App\Events\PusherEvent('Hi there Pusher!'));
    return 'Event sent';
});

#Route url
Route::post('login', 'LoginController@index');

#Admin url
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('dashboard', 'LoginController@dashboard')->middleware('role:Administrador');

	#Faqs CRUD
	Route::middleware(['role:Administrador'])->prefix('faqs')->group(function () {
    	Route::get('/', 'FaqsController@index');
        Route::get('form/{id?}', 'FaqsController@form');
    	Route::post('save', 'FaqsController@save');
    	Route::post('update', 'FaqsController@update');
    	Route::post('delete', 'FaqsController@delete');
	});

    #News CRUD
    Route::middleware(['role:Administrador'])->prefix('noticias')->group(function () {
        Route::get('/', 'NewsController@index');
        Route::get('form/{id?}', 'NewsController@form');
        Route::post('save', 'NewsController@save');
        Route::post('update', 'NewsController@update');
        Route::post('delete', 'NewsController@delete');
    });

    #System API
    Route::middleware(['role:Administrador'])->prefix('system')->group(function () {
        Route::post('change-password', 'UsersController@change_password');
        Route::post('change-profile', 'UsersController@change_profile');
    });

    #Notifications API
    Route::middleware(['role:Administrador'])->prefix('notificaciones')->group(function () {
        Route::get('/', 'NotificationsController@index');
        Route::post('send-notification', 'NotificationsController@send_notificationss');
    });

    #Users CRUD
    Route::middleware(['role:Administrador'])->prefix('users')->group(function () {
        Route::get('/', 'UsersController@index');
    });
});


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
Route::namespace('Web')->name('web.')->group(function(){

    // Dashboard
    Route::namespace('Dashboard')->name('dashboard.')->group(function(){
        Route::get('/', 'DashboardController@index')->name('index');
    });

    // Devices
    Route::namespace('Device')->group(function(){
        Route::resource('devices', 'DeviceController');

        Route::prefix('devices')->name('devices.')->group(function(){
            Route::get('component/{id}', 'ComponentController@show')->name('component');
        });
    });

    // Endpoints
    Route::namespace('Endpoint')->group(function(){
        Route::resource('endpoints', 'EndpointController');
    });

    // Activities
    Route::namespace('Activity')->group(function(){
        Route::resource('activities', 'ActivityController');
    });

});
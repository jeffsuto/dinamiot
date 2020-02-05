<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('V1')->prefix('v1')->name('v1.')->group(function(){

    Route::namespace('Dataset')->prefix('datasets')->name('datasets.')->group(function(){
        Route::get('live-chart', 'LiveChartController@index')->name('live-chart');
    });

    Route::namespace('Component')->prefix('components')->name('components.')->group(function(){
        Route::prefix('value')->name('value.')->group(function(){
            // store component's value
            Route::post('store', 'ValueController@store')->name('store');
        });
    });

    Route::namespace('Activity')->prefix('activities')->name('activities.')->group(function(){
        Route::get('new', 'ActivityController@new')->name('new');
        Route::get('count', 'ActivityController@count')->name('count');

        Route::put('read', 'ActivityController@read')->name('read');
    });

});

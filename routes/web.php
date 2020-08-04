<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', '\App\Http\Controllers\Landing@index');
Route::get('/colors', '\App\Http\Controllers\Landing@colors');
Route::post('/contact-me/send-it', '\App\Http\Controllers\Landing@sendContact');

Route::group(['prefix' => 'webhook'], function() {
    Route::group(['prefix' => 'twitter'], function() {
        Route::get('/', '\App\Http\Controllers\JoeyPepperoni@crcChallenge');
        Route::post('/', '\App\Http\Controllers\JoeyPepperoni@activity');
        Route::get('/startRegister', '\App\Http\Controllers\JoeyPepperoni@register');
        Route::get('/startSubscribe', '\App\Http\Controllers\JoeyPepperoni@addSub');

    });

});

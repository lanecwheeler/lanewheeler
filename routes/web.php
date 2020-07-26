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

Route::get('/', function () {
    return view('landing')->with('rand', function() {
        $rand = rand(0,360);
        while($rand <= 90 && $rand >= 30)
            $rand = rand(0,360);
        return $rand;
    });
});

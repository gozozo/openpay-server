<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
|
|
*/

Route::group(["prefix" => '/openpay', "middleware" => env("MIDDLEWARE_OPENPAY")], function () {
    Route::resource('/cards', 'Gozozo\OpenpayServer\Http\Controllers\CardsController');
});
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

Route::group(["prefix" => '/openpay', "middleware" => env("OPENPAY_MIDDLEWARE")], function () {
    Route::resource('/card', 'Gozozo\OpenpayServer\Http\Controllers\CardController', ['only' => ['store', 'destroy']]);
    Route::resource('/customer', 'Gozozo\OpenpayServer\Http\Controllers\CustomerController', ['only' => ['store', 'destroy']]);
    Route::resource('customer.card', 'Gozozo\OpenpayServer\Http\Controllers\CustomerCardController',['only' => ['index','store','destroy']]);
});
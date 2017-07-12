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

$attr=["prefix" => '/openpay'];

if(env("OPENPAY_MIDDLEWARE") !=="") {
    $attr["middleware"]=env("OPENPAY_MIDDLEWARE");
}

Route::group($attr, function () {
    Route::resource('/customer', 'Gozozo\OpenpayServer\Http\Controllers\CustomerController', ['only' => ['store', 'destroy']]);
    Route::resource('/customer.card', 'Gozozo\OpenpayServer\Http\Controllers\CustomerCardController',['only' => ['index','store','destroy']]);
    Route::resource('/customer.card.charge', 'Gozozo\OpenpayServer\Http\Controllers\CardChargeController',['only' => ['store']]);
});
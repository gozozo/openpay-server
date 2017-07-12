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

use Illuminate\Support\Facades\Route;

$attr=["prefix" => 'api/v1/openpay'];

if(env("OPENPAY_API_MIDDLEWARE") !== "") {
    $attr["middleware"]=env("OPENPAY_API_MIDDLEWARE");
}

Route::group($attr, function () {
    Route::resource('/customer', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerController', ['only' => ['store', 'destroy']]);
    Route::resource('/customer.card', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerCardController',['only' => ['index','store','destroy']]);
    Route::resource('/customer.card.charge', 'Gozozo\OpenpayServer\Http\Controllers\Api\CardChargeController',['only' => ['store']]);
});
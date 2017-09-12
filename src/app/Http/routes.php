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


if(config('openpay.api')) {
    $attr = ["prefix" => config('openpay.api_route')];

    if (config('openpay.api_middleware') !== '') {
        $attr["middleware"] = config('openpay.api_middleware');
    }

    Route::group($attr, function () {
        Route::post('/webhook','Gozozo\OpenpayServer\Http\Controllers\Api\WebhookController@webhook')->name('webhook');
        Route::get('/webhook/code','Gozozo\OpenpayServer\Http\Controllers\Api\WebhookController@code')->name('webhook.code');
        Route::resource('/customer', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerController', ['only' => ['store', 'destroy']]);
        Route::resource('/customer.card', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerCardController', ['only' => ['index', 'store', 'destroy']]);
        Route::resource('/customer.card.charge', 'Gozozo\OpenpayServer\Http\Controllers\Api\CardChargeController', ['only' => ['store']]);
    });
}
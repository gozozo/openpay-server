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

if(config('openpay.api')) {
    $attr = ["prefix" => config('openpay.api_route')];

    if (config('openpay.api_middleware') !== '') {
        $attr["middleware"] = config('openpay.api_middleware');
    }

    Route::group($attr, function () {
        Route::resource('/customer', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerController', ['only' => ['store', 'destroy']]);
        Route::resource('/customer.card', 'Gozozo\OpenpayServer\Http\Controllers\Api\CustomerCardController', ['only' => ['index', 'store', 'destroy']]);
        Route::resource('/customer.card.charge', 'Gozozo\OpenpayServer\Http\Controllers\Api\CardChargeController', ['only' => ['store']]);
    });
}
Route::group(["prefix" => 'openpay'], function () {
    Route::post('webhook', 'Gozozo\OpenpayServer\Http\Controllers\WebhookController@webhook')->name('openpay.webhook');
    Route::get('webhook/code', 'Gozozo\OpenpayServer\Http\Controllers\WebhookController@code')->name('openpay.webhook.code');
    Route::get('payment/store/{id}','Gozozo\OpenpayServer\Http\Controllers\StoreController@storeReceipt')->name('openpay.store');
    Route::get('payment/store/{id}/print','Gozozo\OpenpayServer\Http\Controllers\StoreController@storeReceiptPrint')->name('openpay.store.print');
    Route::get('payment/bank/{id}','Gozozo\OpenpayServer\Http\Controllers\BankController@bankReceipt')->name('openpay.bank');
    Route::get('payment/bank/{id}/print','Gozozo\OpenpayServer\Http\Controllers\BankController@bankReceiptPrint')->name('openpay.bank.print');
});

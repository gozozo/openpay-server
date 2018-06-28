<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Carbon\Carbon;
use Gozozo\OpenpayServer\Openpay;
use Illuminate\Routing\Controller;
use OpenpayApi;

class StoreController extends Controller
{
    /**
     * Openpay
     *
     * @var OpenpayApi
     */
    protected $openpay;

    function __construct(OpenpayApi $openpay, $locale = 'es_ES')
    {
        setlocale(LC_TIME, $locale);
        Carbon::setUtf8(true);
        $this->openpay = $openpay;
    }

    public function storeReceipt($id)
    {

        $charge = Openpay::getCharge($id);
        if (isset($charge) && $charge->method == Openpay::PAYMENT_METHOD_STORE) {
            $customer = $this->openpay->customers->get($charge->customer_id);
        } else {
            abort(404);
        }
        return view('openpay::receipts.paynet.index', compact('charge', 'customer'));

    }

    public function storeReceiptPrint($id)
    {

        $charge = Openpay::getCharge($id);
        if (isset($charge) && $charge->method == Openpay::PAYMENT_METHOD_STORE) {
            $customer = $this->openpay->customers->get($charge->customer_id);
        } else {
            abort(404);
        }
        return view('openpay::receipts.paynet.print', compact('charge', 'customer'));
    }
}
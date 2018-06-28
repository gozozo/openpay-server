<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Carbon\Carbon;
use Gozozo\OpenpayServer\Openpay;
use Illuminate\Routing\Controller;
use OpenpayApi;

class BankController extends Controller
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

    public function bankReceipt($id)
    {

        $charge = Openpay::getCharge($id);
        if (isset($charge) && $charge->method == Openpay::PAYMENT_METHOD_BANK_ACCOUNT) {
            $customer = $this->openpay->customers->get($charge->customer_id);
        } else {
            abort(404);
        }
        return view('openpay::receipts.bank.index', compact('charge', 'customer'));

    }

    public function bankReceiptPrint($id)
    {

        $charge = Openpay::getCharge($id);
        if (isset($charge) && $charge->method == Openpay::PAYMENT_METHOD_BANK_ACCOUNT) {
            $customer = $this->openpay->customers->get($charge->customer_id);
        } else {
            abort(404);
        }
        return view('openpay::receipts.bank.print', compact('charge', 'customer'));
    }
}
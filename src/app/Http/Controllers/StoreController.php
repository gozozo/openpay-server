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

    function __construct(OpenpayApi $openpay)
    {
        $this->openpay = $openpay;
    }

    public function storeReceipt($id){

        $charge =Openpay::getCharge($id);
        if(isset($charge) && $charge->method == 'store'){
            $customer= $this->openpay->customers->get($charge->customer_id);
        }else{
            abort(404);
        }
        setlocale(LC_TIME, 'es_ES');
        Carbon::setUtf8(true);
        return view('openpay::paynet.store',compact('charge','customer'));

    }

    public function storeReceiptPrint($id){

        $charge =Openpay::getCharge($id);
        if(isset($charge) && $charge->method == 'store'){
            $customer= $this->openpay->customers->get($charge->customer_id);
        }else{
            abort(404);
        }
        setlocale(LC_TIME, 'es_ES');
        Carbon::setUtf8(true);
        return view('openpay::paynet.store.print',compact('charge','customer'));
    }
}
<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

require_once(__DIR__ . '/../../openpay-php/Openpay.php');

use Openpay;

class CardChargeController extends Controller
{

    protected $openpay;

    /**
     * CardController constructor
     */
    public function __construct()
    {
        if (getenv('APP_ENV') === 'production') {
            Openpay::setProductionMode(true);
            $this->openpay = Openpay::getInstance(env('OPENPAY_ID_PRODUCTION'), env('OPENPAY_SK_PRODUCTION'));
        } else {
            Openpay::setProductionMode(false);
            $this->openpay = Openpay::getInstance(env('OPENPAY_ID'), env('OPENPAY_SK'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     *
     * * @param  string $cardId
     * @return Response
     */
    public function index($cardId)
    {

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request string $cardId
     * @return Response
     */
    public function store(Request $request,$cardId)
    {
        $chargeData=json_decode($request->get('parameters'),true);
        $openpayReference = OpenpayReferenceModel::where('user_id', $request->get("user_id"))->first();
        try{
            $customer = $this->openpay->customers->get($openpayReference->openpay_id);
            $charge = $customer->charges->create($chargeData);
            return response()->json($charge->serializableData);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }

}
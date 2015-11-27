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
     * Store a newly created resource in storage.
     *
     * @param  Request $request string $cardId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $cardId)
    {
        try {

            $chargeData = json_decode($request->get('parameters'), true);
            $openpayReference = OpenpayReferenceModel::where('user_id', $request->get("user_id"))->first();
            if ($openpayReference == null) {
                return response()->json(
                    array("response" => "error",
                        "class" => "CustomerControllerError",
                        "error" => array(
                            "code" => 101,
                            "message" => "Customer doesn't exist"
                        ))
                );
            }

            $customer = $this->openpay->customers->get($openpayReference->openpay_id);
            $charge = $customer->charges->create($chargeData);

            return response()->json(array("response" => "result", "result" => $charge->serializableData));

        } catch (\OpenpayApiError $e) {
            return response()->json(
                array(
                    "response" => "error",
                    "class" => get_class($e),
                    "error" => array(
                        "code" => $e->getErrorCode(), "message" => $e->getMessage(),
                        "http_code" => $e->getHttpCode(), "category" => $e->getCategory()
                    )));
        } catch (\Exception $e) {
            return response()->json(
                array("response" => "error",
                    "class" => get_class($e),
                    "error" => array(
                        "code" => $e->getCode(),
                        "message" => $e->getMessage()
                    ))
            );
        }
    }

}
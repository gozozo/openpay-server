<?php

namespace Gozozo\OpenpayServer\Http\Controllers\Api;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenpayApi;

class CardChargeController extends Controller
{

    protected $openpay;

    /**
 * CardController constructor
 * @param OpenpayApi $openpay
 */
    public function __construct(OpenpayApi $openpay)
    {
        $this->openpay=  $openpay;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request string $cardId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $customerId, $cardId)
    {
        try {

            $chargeData = json_decode($request->get('parameters'), true);
            $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();
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

            return response()->json(array("response" => "result", "result" =>$this->responseArray($charge) ));

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
    public function responseArray($class)
    {
        if(get_class($class) == 'OpenpayCharge'){
            $data = array();
            $data = $class->serializableData;
            $data['card']=$class->card->serializableData;
            $data['fee']=$class->fee->serializableData;
            if(isset($class->exchange_rate)){
                $data['exchange_rate']=$class->exchange_rate->serializableData;
            }
            return $data;
        }
        return null;
    }
}
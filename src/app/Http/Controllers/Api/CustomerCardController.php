<?php

namespace Gozozo\OpenpayServer\Http\Controllers\Api;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use OpenpayApi;

class CustomerCardController extends Controller
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
     * Display a listing of the resource.
     *
     * @param  string $customerId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($customerId)
    {
        //TODO Create dynamic values
        $findDataRequest = array(
            'creation[lte]' => Carbon::today()->addDay(1)->toDateString(),
            'offset' => 0,
            'limit' => 100);

        try {

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
            $cardList = $customer->cards->getList($findDataRequest);

            $data = array();
            //TODO Create dynamic values
            foreach ($cardList as $card) {
                $cardData = array();
                $cardData["card_number"] = $card->card_number;
                $cardData["id"] = $card->id;
                $cardData["brand"] = $card->brand;
                array_push($data, $cardData);
            }

            return response()->json(array("response" => "result", "result" => $data));

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @param string $customerId
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, $customerId)
    {
        try {

            $cardData = json_decode($request->get('parameters'), true);

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
            $card = $customer->cards->add($cardData);

            return response()->json(array("response" => "result", "result" => $card->serializableData));

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $customerId ,
     * @param int $cardId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId, $cardId)
    {
        try {

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
            $card = $customer->cards->get($cardId);
            $card->delete();

            return response()->json(array("response" => "ok"));

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
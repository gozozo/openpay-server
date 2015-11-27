<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

require_once(__DIR__ . '/../../openpay-php/Openpay.php');

use Openpay;

class CustomerCardController extends Controller
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
     * @param  string $customerId,
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($customerId)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();

        $findDataRequest = array(
            'creation[lte]' => '2015-12-31',
            'offset' => 0,
            'limit' => 100);

        try {

            $customer = $this->openpay->customers->get($openpayReference->openpay_id);
            $cardList = $customer->cards->getList($findDataRequest);

            $data =array();

            foreach($cardList as $card){
                $cardData=$card->serializableData;
                $cardData["id"]=$card->id;
                array_push($data,$cardData);
            }

            return response()->json(array("response" => "result", "result" =>$data));

        }catch (\OpenpayApiError $e) {
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
                        "code" => $e->getErrorCode(),
                        "message" => $e->getMessage()
                    ))
            );
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, $customerId)
    {
        $cardData=json_decode($request->get('parameters'),true);
        $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();

        try {

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
                        "code" => $e->getErrorCode(),
                        "message" => $e->getMessage()
                    ))
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $customerId, int $cardId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId, $cardId)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();

        try {

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
                        "code" => $e->getErrorCode(),
                        "message" => $e->getMessage()
                    ))
            );
        }
    }
}
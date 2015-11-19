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
     * @return Response
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
                array_push($data,$card->serializableData);
            }
            return response()->json($data);

        } catch (\OpenpayApiError $e) {
            return response()->json($e);
        }

    }

    public function store(Request $request, $customerId)
    {
        $cardData=json_decode($request->get('parameters'),true);

        $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();
        try {
            $customer = $this->openpay->customers->get($openpayReference->openpay_id);
            $card = $customer->cards->add($cardData);
            return response()->json($card->serializableData);
        } catch (\OpenpayApiError $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $customerId, int $cardId
     * @return Response
     */
    public function destroy($customerId, $cardId)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $customerId)->first();

        try {
            $customer = $this->openpay->customers->get($openpayReference->openpay_id);
            $card = $customer->cards->get($cardId);
            $card->delete();
        } catch (\OpenpayApiError $e) {
            return response()->json($e);
        }
    }
}
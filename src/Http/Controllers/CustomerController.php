<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

require_once(__DIR__ . '/../../openpay-php/Openpay.php');

use Openpay;

class CustomerController extends Controller
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
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $customerData=json_decode($request->get('parameters'),true);

        try {
            $customer = $this->openpay->customers->add($customerData);

            //Save data to our server
            $openpayReferenceModel =new OpenpayReferenceModel();
            $openpayReferenceModel->user_id=$request->get('user_id');
            $openpayReferenceModel->openpay_id=$customer->id;
            $openpayReferenceModel->save();

            return response()->json($customer->serializableData);

        } catch (\OpenpayApiError $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $customerId
     * @return Response
     */
    public function destroy($customerId)
    {
        //
        try {
            $customer = $this->openpay->customers->get($customerId);
            $customer->delete();

            //Delete data to our server
            $openpayReference = OpenpayReferenceModel::where('openpay_id', $customerId)->first();
            $openpayReference->delete();;

        } catch (\OpenpayApiError $e) {
            return response()->json($e);
        }
    }
}
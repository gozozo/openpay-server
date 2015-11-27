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
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {

            $customerData = json_decode($request->get('parameters'), true);

            //Check if not exist user
            $openpayReference = OpenpayReferenceModel::where('user_id', $request->get('user_id'))->first();
            if ($openpayReference != null) {
                return response()->json(
                    array("response" => "error",
                        "class" => "CustomerControllerError",
                        "error" => array(
                            "code" => 100,
                            "message" => "Customer exist"
                        ))
                );
            }

            //Add new Customer
            $customer = $this->openpay->customers->add($customerData);

            //Save data to our server
            $openpayReference = new OpenpayReferenceModel();
            $openpayReference->user_id = $request->get('user_id');
            $openpayReference->openpay_id = $customer->id;
            $openpayReference->save();

            return response()->json(array("response" => "result", "result" => $customer->serializableData));

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
     * @param  string $customerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($customerId)
    {
        try {

            $customer = $this->openpay->customers->get($customerId);
            $customer->delete();

            //Delete data to our server
            $openpayReference = OpenpayReferenceModel::where('openpay_id', $customerId)->first();
            if ($openpayReference == null) {
                return response()->json(
                    array("response" => "error",
                        "class" => "CustomerControllerError",
                        "error" => array(
                            "code" => 101,
                            "message" => "Customer doesn't exist"
                        ))
                );
            }else{
                $openpayReference->delete();
                return response()->json(array("response" => "ok"));
            }


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
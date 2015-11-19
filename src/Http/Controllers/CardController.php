<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

require_once(__DIR__ . '/../../openpay-php/Openpay.php');

use Openpay;

class CardController extends Controller
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
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
<?php

namespace Gozozo\OpenpayServer\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

require_once(__DIR__.'/../../openpay-php/Openpay.php');

use Openpay;

class CardsController extends Controller
{

    protected  $openpay;
    /**
     * CardsController constructor
     */
    public function __construct()
    {
        $openpay = Openpay::getInstance(env('OPENPAY_ID'),env('OPENPAY_SK'));

        /*
            $chargeData = array(
                'method' => 'card',
                'source_id' => $request->get('token_id'),
                'amount' => (float)$request->get('amount'),
                'description' => $request->get('description"'),
                'use_card_points' => $request->get('use_card_points'), // Opcional, si estamos usando puntos
                'device_session_id' => $request->get('deviceIdHiddenFieldName"));

            */
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
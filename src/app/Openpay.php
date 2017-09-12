<?php
/**
 * Created by gozozo.
 * Date: 7/12/17
 * Time: 9:27 PM
 */

namespace Gozozo\OpenpayServer;

use Gozozo\OpenpayServer\Models\OpenpayPayorderReferenceModel;
use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Gozozo\OpenpayServer\Objects\Card;
use Gozozo\OpenpayServer\Objects\PayOrder;
use OpenpayApi;
use OpenpayCharge;

class Openpay
{

    /**
     * Get all cards from a customer.   Check documentation on https://www.openpay.mx/docs/api/#listado-de-tarjetas
     *
     * @param int $external_id      External id
     * @param array $filter         Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     * @return array
     */
    public static function allCardsFromCustomer($external_id, array $filter = [])
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->getList($filter);
    }

    /**
     * Add card to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta
     * 
     * @param int $external_id      External id
     * @param Card $creditCard      Card
     * @return \OpenpayCard
     */
    public static function addCardToCustomer ($external_id, Card $creditCard){
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->add($creditCard->toArray());
    }

    /***********************************************
     *                 PAY ORDER
     ***********************************************/

    /**
     * Create pay order.    Check documentation on https://www.openpay.mx/docs/api/?php#con-terminal-virtual
     *
     * @param int $external_id      External id
     * @param PayOrder $payOrder
     * @return mixed
     */
    public static  function  cretePayOrder($external_id, PayOrder $payOrder){
        $response = Openpay::instance()->charges->create($payOrder->toArray());
        $openpayPOR = new OpenpayPayorderReferenceModel;
        $openpayPOR->user_id = $external_id;
        $openpayPOR->openpay_id = $response->id;
        $openpayPOR->save();
        return true;
    }

    /**
     * Get pay order.    Check documentation on https://www.openpay.mx/docs/api/?php#obtener-un-cargo
     *
     * @param String $transaction_id      Transaction id
     * @return OpenpayCharge
     */
    public static  function  getPayOrder($transaction_id){
        $response = Openpay::instance()->charges->get($transaction_id);
        return $response;
    }

    /**
     * Get all changes.     Check documentation on https://www.openpay.mx/docs/api/?php#listado-de-cargos
     *
     * @param array $filter     Data filter - example: array('creation[gte]' => '2013-11-01','creation[lte]' => '2014-11-01','offset' => 0,'limit' => 2);
     * @return array
     */
    public static function allChargesFromCommerce(array $filter = []){
        return Openpay::instance()->charges->getList($filter);
    }

    /**
     * Get instance
     *
     * @return OpenpayApi
     */
    private static function instance(){
        $instance = OpenpayApi::getInstance(null);
        if(isset($instance)&& $instance->id !='' &&$instance->apiKey != ''){
            return $instance;
        }else{
            \Openpay::setProductionMode(!config('openpay.sandbox'));
            return \Openpay::getInstance(config('openpay.id'), config('openpay.sk'));
        }
    }
}
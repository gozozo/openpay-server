<?php
/**
 * Created by gozozo.
 * Date: 7/12/17
 * Time: 9:27 PM
 */

namespace Gozozo\OpenpayServer;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Gozozo\OpenpayServer\Objects\Card;
use Gozozo\OpenpayServer\Objects\CardToken;
use Gozozo\OpenpayServer\Objects\Charge;
use Gozozo\OpenpayServer\Objects\PayOrder;
use OpenpayApi;
use OpenpayCharge;

class Openpay
{
    /**
     * Get instance
     *
     * @return OpenpayApi
     */
    public static function instance(){
        $instance = OpenpayApi::getInstance(null);
        if(isset($instance)&& $instance->id !='' &&$instance->apiKey != ''){
            return $instance;
        }else{
            \Openpay::setProductionMode(config('openpay.production'));
            return \Openpay::getInstance(config('openpay.id'), config('openpay.sk'));
        }
    }

    /***********************************************
     *                 CHARGES
     **********************************************/

     /**
     * Create customer charge. This type of charge requires a saved card or a previously generated token.   Check documentation on https://www.openpay.mx/docs/api/#con-id-de-tarjeta-o-token
     *
     * @param $external_id
     * @param Charge $charge
     *
     * @return OpenpayCharge
     */

    public static function createCustomerCharge($external_id,Charge $charge)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        $charge = $customer->charges->create($charge->toArray());
        return $charge;
    }

    /***********************************************
     *                 CUSTOMERS
     **********************************************/

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

    /**
     * Add card to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta-con-token
     *
     * @param int $external_id      External id
     * @param CardToken $cardToken      CardToken
     * @return \OpenpayCard
     */
    public static function addCardTokenToCustomer($external_id, CardToken $cardToken){
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->add($cardToken->toArray());
    }


    /***********************************************
     *                 PAY ORDER
     ***********************************************/

    /**
     * Create pay order.    Check documentation on https://www.openpay.mx/docs/api/?php#con-terminal-virtual
     *
     * @param PayOrder $payOrder
     * @return OpenpayCharge
     */
    public static  function createPayOrder(PayOrder $payOrder){
        $response = Openpay::instance()->charges->create($payOrder->toArray());
        return $response;
    }

    /***********************************************
     *                 COMMERCE
     **********************************************/

    /**
     * Get all changes.     Check documentation on https://www.openpay.mx/docs/api/?php#listado-de-cargos
     *
     * @param array $filter     Data filter - example: array('creation[gte]' => '2013-11-01','creation[lte]' => '2014-11-01','offset' => 0,'limit' => 2);
     * @return array
     */
    public static function allChargesFromCommerce(array $filter = []){
        return Openpay::instance()->charges->getList($filter);
    }

    /***********************************************
     *                 Charge
     **********************************************/
    /**
     * Get charge  to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta
     *
     * @param string $transaction_id      Id Transaction;
     * @return \OpenpayCard
     * */
    public static function getCharge($transaction_id)
    {
        $response = Openpay::instance()->charges->get($transaction_id);
        return $response;
    }

}
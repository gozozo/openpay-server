<?php
/**
 * Created by gozozo.
 * Date: 7/12/17
 * Time: 9:27 PM
 */

namespace Gozozo\OpenpayServer;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Gozozo\OpenpayServer\Objects\BankPayment;
use Gozozo\OpenpayServer\Objects\Card;
use Gozozo\OpenpayServer\Objects\CardToken;
use Gozozo\OpenpayServer\Objects\Charge;
use Gozozo\OpenpayServer\Objects\PayOrder;
use Gozozo\OpenpayServer\Objects\StorePayment;
use Gozozo\OpenpayServer\Objects\Subscription;
use OpenpayApi;
use OpenpayApiRequestError;
use OpenpayApiTransactionError;
use OpenpayCharge;

class Openpay
{
    const PAYMENT_METHOD_BANK_ACCOUNT = 'bank_account';
    const PAYMENT_METHOD_STORE = 'store';

    /**
     * Get instance
     *
     * @return OpenpayApi
     */
    public static function instance()
    {
        $instance = OpenpayApi::getInstance(null);
        if (isset($instance) && $instance->id != '' && $instance->apiKey != '') {
            return $instance;
        } else {
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
     * @param $externalId
     * @param Charge $charge
     *
     * @return OpenpayCharge
     * @throws OpenpayApiTransactionError|OpenpayApiRequestError
     */

    public static function createCustomerCharge($externalId, Charge $charge)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        $charge = $customer->charges->create($charge->toArray());
        return $charge;
    }

    /**
     * Get cards from a customer.   Check documentation on https://www.openpay.mx/docs/api/#listado-de-tarjetas
     *
     * @param int $externalId External id
     * @param array $filter Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     *
     * @return \OpenpayCardList
     */
    public static function getCardsFromCustomer($externalId, array $filter = [])
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->getList($filter);
    }

    /**
     * Get cards from a customer.   Check documentation on https://www.openpay.mx/docs/api/#listado-de-tarjetas
     *
     * @param int $externalId External id
     * @param array $filter Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     *
     * @return \OpenpayCard
     */
    public static function getCardFromCustomer($externalId, $cardId)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->get($cardId);
    }

    /**
     * Get suscripciones from a customer.   Check documentation on https://www.openpay.mx/docs/api/#listado-de-suscripciones
     *
     * @param int $externalId External id
     * @param array $filter Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     *
     * @return \OpenpaySubscriptionList
     */
    public static function getSuscripcionesFromCustomer($externalId, array $filter = [])
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->subscriptions->getList($filter);
    }

    /**
     * Add card to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta
     *
     * @param int $externalId External id
     * @param Card $creditCard Card
     *
     * @return \OpenpayCard
     */
    public static function addCardToCustomer($externalId, Card $creditCard)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->add($creditCard->toArray());
    }

    /**
     * Add card to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta-con-token
     *
     * @param int $externalId External id
     * @param CardToken $cardToken CardToken
     *
     * @return \OpenpayCard
     */
    public static function addCardTokenToCustomer($externalId, CardToken $cardToken)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->cards->add($cardToken->toArray());
    }


    /**
     * Remove card from customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta
     *
     * @param int $externalId External id
     * @param Card $creditCard Card
     *
     * @throws OpenpayApiError|OpenpayApiTransactionError|OpenpayApiRequestError
     */
    public static function removeCardFromCustomer($externalId, $cardId)
    {
        $card = self::getCardFromCustomer($externalId, $cardId);
        $card->delete();
    }

    /***********************************************
     *                 PAY ORDER
     ***********************************************/

    /**
     * Create pay order.    Check documentation on https://www.openpay.mx/docs/api/?php#con-terminal-virtual
     *
     * @param PayOrder $payOrder
     *
     * @return OpenpayCharge
     * @throws OpenpayApiTransactionError|OpenpayApiRequestError
     */
    public static function createPayOrder(PayOrder $payOrder)
    {
        $response = Openpay::instance()->charges->create($payOrder->toArray());
        return $response;
    }

    /***********************************************
     *                 COMMERCE
     **********************************************/

    /**
     * Get all changes.     Check documentation on https://www.openpay.mx/docs/api/?php#listado-de-cargos
     *
     * @param array $filter Data filter - example: array('creation[gte]' => '2013-11-01','creation[lte]' => '2014-11-01','offset' => 0,'limit' => 2);
     * @return array
     */
    public static function allChargesFromCommerce(array $filter = [])
    {
        return Openpay::instance()->charges->getList($filter);
    }

    /***********************************************
     *                 Charge
     **********************************************/
    /**
     * Get charge  to customer.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-tarjeta
     *
     * @param string $transaction_id Id Transaction;
     *
     * @return \OpenpayCharge
     * */
    public static function getCharge($transaction_id)
    {
        $response = Openpay::instance()->charges->get($transaction_id);
        return $response;
    }


    /***********************************************
     *                 STORE PAYMENTS
     ***********************************************/

    /**
     * Create payment via a store.    Check documentation on https://www.openpay.mx/docs/api/?php#cargo-en-tienda
     *
     * @param $externalId
     * @param StorePayment $storePayment
     *
     * @return \OpenpayCharge
     * @throws OpenpayApiTransactionError|OpenpayApiRequestError
     */
    public static function createStorePayment($externalId, StorePayment $storePayment)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        $charge = $customer->charges->create($storePayment->toArray());
        return $charge;
    }

    /***********************************************
     *                 STORE BANK
     ***********************************************/

    /**
     * Create charge via Bank.    Check documentation on https://www.openpay.mx/docs/api/?php#cargo-en-tienda
     *
     * @param $externalId
     * @param BankPayment $bankPayment
     *
     * @return \OpenpayCharge
     * @throws OpenpayApiTransactionError|OpenpayApiRequestError
     */
    public static function createBankPayment($externalId, BankPayment $bankPayment)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        $charge = $customer->charges->create($bankPayment->toArray());
        return $charge;
    }

    /***********************************************
     *                 PLANS
     **********************************************/

    /**
     * Get plans.   Check documentation on https://www.openpay.mx/docs/api/?php#listado-de-planes
     *
     * @param array $filter Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     * @return \OpenpayPlanList
     */
    public static function getPlans(array $filter = [])
    {
        return Openpay::instance()->plans->getList($filter);;
    }

    /**
     * Get plan by ID.   Check documentation on https://www.openpay.mx/docs/api/?php#obtener-un-plan
     *
     * @param $plan_id
     * @return \OpenpayPlan
     */
    public static function getPlanById($plan_id)
    {
        return Openpay::instance()->plans->get($plan_id);
    }

    /***********************************************
     *                 SUBSCRIPTIONS
     **********************************************/
    /**
     * Add subscriptions to customer with card id.    Check documentation on https://www.openpay.mx/docs/api/?php#crear-una-nueva-suscripci-n
     *
     * @param int $externalId External id
     * @param Subscription $subscription
     * @return \OpenpaySubscription
     */
    public static function addSubscriptionToCustomerWithCardId($externalId, Subscription $subscription)
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $externalId)->first();
        $customer = Openpay::instance()->customers->get($openpayReference->openpay_id);
        return $customer->subscriptions->add($subscription->toArray());
    }
}
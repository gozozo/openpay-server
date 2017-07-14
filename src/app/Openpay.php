<?php
/**
 * Created by gozozo.
 * Date: 7/12/17
 * Time: 9:27 PM
 */

namespace Gozozo\OpenpayServer;

use Gozozo\OpenpayServer\Models\OpenpayReferenceModel;
use Gozozo\OpenpayServer\Objects\Card;
use OpenpayApi;

class Openpay
{

    /**
     * Get all cards from a customer. Check doc to create filter https://www.openpay.mx/docs/api/#listado-de-tarjetas
     *
     * @param int $external_id      External id
     * @param array $filter         Data filter - example: array('creation[gte]' => '2013-01-01','creation[lte]' => '2013-12-31','offset' => 0,'limit' => 5);
     * @return array
     */
    public static function allCardsFromCustomer($external_id, array $filter = [])
    {
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = OpenpayApi::getInstance(null)->customers->get($openpayReference->openpay_id);
        $cardList = $customer->cards->getList($filter);
        return $cardList;
    }

    /**
     * Add card to customer
     *
     * @param int $external_id      External id
     * @param Card $creditCard      Card
     * @return \OpenpayCard
     */
    public static function addCardToCustomer ($external_id, Card $creditCard){
        $openpayReference = OpenpayReferenceModel::where('user_id', $external_id)->first();
        $customer = OpenpayApi::getInstance(null)->customers->get($openpayReference->openpay_id);
        $card = $customer->cards->add($creditCard->toArray());
        return $card;
    }


}
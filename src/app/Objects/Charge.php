<?php
/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 12:41 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class Charge
{
    use ActionObjects;

    public $method;
    public $source_id;
    public $amount;
    public $cvv2;
    public $currency;
    public $description;
    public $order_id;
    public $device_session_id;
    public $capture;
    public $customer;
    public $payment_plan;
    public $metadata;
    public $use_card_points;
    public $send_email;
    public $redirect_url;

}
<?php
/**
 * Created by PhpStorm.
 * User: gozozo
 * Date: 7/14/17
 * Time: 8:26 PM
 */

namespace Gozozo\OpenpayServer\Objects;


use Gozozo\OpenpayServer\Traits\ActionObjects;

class PayOrder
{
    use ActionObjects;

    public $method;
    public $amount;
    public $description;
    public $customer;
    public $send_email;
    public $confirm;
    public $redirect_url;

    function __construct($confirm = false, $method='card')
    {
        $this->confirm = $confirm;
        $this->method = $method;
    }

}
<?php
/**
 * User: gozozo
 * Date: 5/16/18
 * Time: 11:44 AM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class StorePayment
{
    use ActionObjects;

    public $method;
    public $amount;
    public $description;
    public $order_id;
    public $due_date;

    function __construct()
    {
        $this->method = 'store';
    }

}
<?php
/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 12:41 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class Customer
{
    use ActionObjects;

    public $external_id;
    public $name;
    public $last_name;
    public $email;
    public $requires_account;
    public $phone_number;
    public $address;

}
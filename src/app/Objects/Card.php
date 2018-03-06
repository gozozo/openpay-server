<?php
/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 12:41 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class Card
{
    use ActionObjects;

    public $source_id;
    public $holder_name;
    public $card_number;
    public $cvv2;
    public $expiration_month;
    public $expiration_year;
    public $address;
}
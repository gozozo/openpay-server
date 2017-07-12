<?php
/**
 * Created by PhpStorm.
 * User: gozozo
 * Date: 7/12/17
 * Time: 1:43 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class OpenpayReference
{
    use ActionObjects;

    public $user_id;
    public $openpay_id;
}
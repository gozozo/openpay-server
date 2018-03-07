<?php
/**
 * Created by Gozozo.
 * Date: 7/12/17
 * Time: 12:41 PM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class CardToken
{
    use ActionObjects;

    public $token_id;
    public $device_session_id;

}
<?php
/**
 * User: gozozo
 * Date: 5/16/18
 * Time: 11:44 AM
 */

namespace Gozozo\OpenpayServer\Objects;

use Gozozo\OpenpayServer\Traits\ActionObjects;

class Subscription
{
    use ActionObjects;

    public $id;
    public $creation_date;
    public $cancel_at_period_end;
    public $charge_date;
    public $current_period_number;
    public $period_end_date;
    public $trial_end_date;
    public $plan_id;
    public $status;
    public $source_id;
    public $card;

}
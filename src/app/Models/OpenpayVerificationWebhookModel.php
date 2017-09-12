<?php

namespace Gozozo\OpenpayServer\Models;

use Illuminate\Database\Eloquent\Model;

class OpenpayVerificationWebhookModel extends Model
{

    protected $table = "openpay_verification_webhook";

    protected $fillable = ['event_date','verification_code'];

    protected $primaryKey = "id";

}
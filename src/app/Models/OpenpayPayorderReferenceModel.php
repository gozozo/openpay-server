<?php

namespace Gozozo\OpenpayServer\Models;

use Illuminate\Database\Eloquent\Model;

class OpenpayPayorderReferenceModel extends Model
{

    protected $table = "openpay_payorder_reference";

    protected $fillable = ['user_id', 'openpay_id'];

    protected $primaryKey = "id";

}
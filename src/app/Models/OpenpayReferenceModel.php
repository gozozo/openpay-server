<?php

namespace Gozozo\OpenpayServer\Models;

use Illuminate\Database\Eloquent\Model;

class OpenpayReferenceModel extends Model
{

    protected $table = "openpay_reference";

    protected $fillable = ['user_id', 'openpay_id'];

    protected $primaryKey = "id";

}
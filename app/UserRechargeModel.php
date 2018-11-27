<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRechargeModel extends Model
{
    protected $table = 'user_recharge';
    protected $fillable = ['no', 'user_id','type','money'];
}

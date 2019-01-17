<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserActionLogModel extends Model
{
    protected $table = 'user_action_log';
    protected $fillable = ['mode', 'user_id', 'action','payload','token'];
}

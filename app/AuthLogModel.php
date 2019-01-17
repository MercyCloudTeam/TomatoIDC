<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthLogModel extends Model
{
    protected $table = 'auth_log';
    protected $fillable = ['mode', 'user_id', 'token'];
}

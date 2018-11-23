<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostModel extends Model
{
    protected $table = 'hosts';
    protected $fillable = ['order_id', 'user_id', 'host_name', 'host_pass', 'host_panel', 'host_url'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function order()
    {
        return $this->hasOne('App\OrderModel', 'id', 'order_id');
    }
}

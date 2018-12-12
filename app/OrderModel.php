<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $fillable = ['good_id', 'no', 'user_id', 'aff_no', 'deadline','type', 'price','domain'];

    public function good()
    {
        return $this->hasOne('App\GoodModel', 'id', 'good_id');
    }

    public function host()
    {
        return $this->hasOne('App\HostModel', 'id', 'host_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}

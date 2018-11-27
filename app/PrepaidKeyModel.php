<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrepaidKeyModel extends Model
{
    protected $table = 'prepaid_keys';
    protected $fillable = ['key','account','deadline'];

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }
}

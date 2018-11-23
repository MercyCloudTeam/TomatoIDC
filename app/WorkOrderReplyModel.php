<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderReplyModel extends Model
{
    protected $fillable = ['work_order_id', 'content', 'user_id'];
    protected $table = 'work_order_reply';

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}

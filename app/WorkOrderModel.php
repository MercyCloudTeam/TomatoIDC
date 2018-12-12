<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkOrderModel extends Model
{
    protected $fillable = ['title', 'content', 'user_id','order_no','priority'];
    protected $table = 'work_order';

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChargingModel extends Model
{
    use SoftDeletes;

    protected $table = 'charging';

    protected $fillable = ['time', 'unit', 'money', 'good_id', 'content'];

    public function getGood()
    {
        return $this->hasOne('App\GoodModel', 'id', 'good_id');
    }

    public function getUnitAttribute($value)
    {
        if (config('app.locale') == "zh-CN") {
            switch ($value) {
                case "day":
                    return "天";
                    break;
                case "month":
                    return "月";
                    break;
                case  "year":
                    return "年";
                    break;
            }
        }
      return $value;
    }

}

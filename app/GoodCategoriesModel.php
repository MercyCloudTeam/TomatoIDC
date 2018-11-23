<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodCategoriesModel extends Model
{
    protected $table = 'goods_categories';

    protected $fillable = ['title', 'subtitle', 'content', 'display', 'level'];

    public function getGood()
    {
        return $this->hasMany('App\GoodModel', 'categories_id', 'id');
    }


}

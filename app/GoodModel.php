<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodModel extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $fillable = ['title', 'subtitle', 'price', 'description', 'level', 'display', 'configure_id', 'categories_id', 'server_id','purchase_limit','inventory','domain_config'];

    /**
     * 获取此商品所属分组
     */
    public function getGoodCategories()
    {
        return $this->belongsTo('App\GoodCategoriesModel', 'id', 'categories_id');
    }

    /**
     * 获取此商品所属分组
     */
    public function getGoodConfigure()
    {
        return $this->belongsTo('App\GoodConfigureModel', 'id', 'configure_id');
    }

    /**
     * 获取此商品所属分组
     */
    public function server()
    {
        return $this->hasOne('App\ServerModel', 'id', 'server_id');
    }


    /**
     * 商品类别修改器
     * @param $value
     * @return string
     */
    public function getCategoriesIdAttribute($value)
    {
        if (empty($value)) {
            return '未分组';
        }
        else {
            return GoodCategoriesModel::find($value)->title;
        }
    }

    /**
     * 状态修改器
     * 推荐标识状态class 状态中文 数据表对应数字
     * 出售中 1
     * 已售完 2
     * 已下架 3
     * 已删除 0
     * @param $value
     * @return string
     */
    public function getStatusAttribute($value)
    {

        switch ($value) {
            case 1:
                return '出售中';
            case 2:
                return '已下架';
            default:
                return $value;
        }
    }
}

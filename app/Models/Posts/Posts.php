<?php

namespace App\Models\Posts;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Posts extends Model
{
    use HasDateTimeFormatter;

    protected $connection = 'posts_mysql';

    protected $table ='posts';

    protected $fillable = [
        'type',
        'content_type',
        'title',
        'source',
        'subtitle',
        'content',
        'status',
        'category_id',
        'img'
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query): mixed
    {
        return $query->where([
            ['status','=',1]
        ])->orderBy('level','desc');
    }

    /**
     * @return HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne('App\PostsCategory','id','category_id');
    }

    /**
     * @param $value
     * @return string
     */
    public function getCategoryTitleAttribute($value): string
    {
        $category = $this->category;
        if (!empty($category)){
            return $category->title;
        }
        return "未分類";
    }

}

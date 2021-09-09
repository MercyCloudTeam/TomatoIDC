<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'posts_mysql';

    protected $table = 'posts_categories';

    protected $fillable = [
        'title','content','subtitle','status','pid','level'
    ];

    public function scopeActive($query)
    {
        return $query->where([
            ['status','=',1]
        ])->orderBy('level','desc');
    }
}

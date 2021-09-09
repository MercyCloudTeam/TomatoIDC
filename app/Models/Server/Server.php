<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = "servers";

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'code',
        'servers_connect_id',
        'status',
        'token_id',
        'node',
        'storage',
        'config',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'config' => 'array',
    ];


    /**
     * 模型关联
     * @return HasOne
     */
    public function connect(): HasOne
    {
        return $this->hasOne('App\Models\Server\Connect','id','servers_connect_id');
    }

    /**
     * 模型关联
     * @return HasMany
     */
    public function setups(): HasMany
    {
        return $this->hasMany('App\Models\Server\Setup','server_id','id');
    }

    /**
     * 模型关联
     * @return HasMany
     */
    public function service(): HasMany
    {
        return $this->hasMany('App\Models\Service\Service','server_id','id');
    }

    /**
     * 模型关联
     * @return HasOne
     */
    public function token(): HasOne
    {
        return $this->hasOne('App\Models\Server\Token','id','token_id');
    }


}

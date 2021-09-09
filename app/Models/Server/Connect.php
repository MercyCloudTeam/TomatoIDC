<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Connect extends Model
{

    /**
     * @var string
     */
    protected $table = 'servers_connect';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'status',
        'host',
        'method',
        'port',
        'type',
    ];

    /**
     * @return HasManyThrough
     */
    public function tokens(): HasManyThrough
    {
        return $this->hasManyThrough(
            'App\Models\Server\Token',
            'App\Models\Server\TokenAssociation',
            'servers_connect_id',
            'id',
            'id',
            'servers_token_id'
            );
    }

    /**
     * @return HasMany
     */
    public function servers(): HasMany
    {
        return $this->hasMany('App\Models\Server\Server','servers_connect_id','id');
    }
}

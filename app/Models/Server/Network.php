<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{

    /**
     * @var string
     */
    protected $table = 'servers_network';

    /**
     * @var string[]
     */
    protected $fillable = [
        'server_token_id',
        'type',
        'host',
        'method',
        'port',
        'title',
        'status',
        'config',
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'config' => 'array',
    ];

}

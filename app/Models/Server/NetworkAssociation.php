<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class NetworkAssociation extends Model
{

    /**
     * @var string
     */
    protected $table = 'servers_network_association';

    /**
     * @var string[]
     */
    protected $fillable = [
        'servers_network_id',
        'server_id'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'config' => 'array',
    ];



}

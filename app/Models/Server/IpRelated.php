<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class IpRelated extends Model
{

    /**
     * @var string
     */
    protected $table = 'ip_related';

    /**
     * @var string[]
     */
    protected $fillable = [
        'server_id',
        'ip_pool_id',
        'bridge',
    ];
}

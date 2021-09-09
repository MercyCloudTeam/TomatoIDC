<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IpAllocation extends Model
{

    /**
     * @var string
     */
    protected $table = 'ip_allocation';

    /**
     * @var string[]
     */
    protected $fillable = [
        'ip',
        'ip_pool_id',
        'server_id',
        'type',
        'service_id',
        'filler',
        'user_id',
        'secondary',
        'config',
        'net_type',
        'vlan',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'filler'=>'array',
        'config'=>'array'
    ];

    public function service(): HasMany
    {
        return $this->hasMany('App\Models\Service\Service','uuid','service_id');
    }
}

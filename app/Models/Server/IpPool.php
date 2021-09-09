<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class IpPool extends Model
{

    /**
     * @var string 数据表名称
     */
    protected $table = 'ip_pool';

    /**
     * @var string[] 可存储字段
     */
    protected $fillable = [
        'ip',
        'type',
        'ip_type',
        'gateway',
        'netmask',
        'cidr',
        'subnet',
        'net_type',
        'mac',
        'config',
        'vlan'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'config'=>'array'
    ];

}

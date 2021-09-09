<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class ResourcePool extends Model
{

    /**
     * @var string
     */
    protected $table = 'servers_resource_pool';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'config',
        'code',
        'type',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'config' => 'array',
    ];

}

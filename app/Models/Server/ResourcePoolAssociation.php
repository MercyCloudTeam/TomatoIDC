<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ResourcePoolAssociation extends Model
{

    /**
     * @var string
     */
    protected $table = 'servers_resource_pool_association';

    /**
     * @var string[]
     */
    protected $fillable = [
        'servers_resource_pool_id',
        'server_id'
    ];




}

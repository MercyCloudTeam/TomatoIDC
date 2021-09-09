<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class ServerAddons extends Model
{
    protected $table = 'servers_addons';

    protected $fillable = [
        'config',
        'type',
        'server_id'
    ];


}

<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'servers_status';

    protected $connection = 'logs_mysql';

    protected $fillable = [
        'server_id',
        'params',
        'created_at',
    ];

    public $timestamps = false;

}

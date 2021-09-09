<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{

    protected $table = 'servers_setup';

    protected $fillable = [
        'name',
        'type',
        'config',
        'server_id',
    ];

    protected $casts =[
      'config'=>'array'
    ];



}

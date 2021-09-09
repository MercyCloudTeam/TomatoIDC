<?php

namespace App\Models\Server;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class TokenAssociation extends Model
{

    protected $table = 'servers_token_association';

    protected $fillable = [
        'servers_token_id',
        'servers_connect_id'
    ];


}

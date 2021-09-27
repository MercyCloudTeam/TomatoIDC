<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetup extends Model
{
    use HasFactory;

    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'system_setups';

    protected $fillable = [
        'name','value','type'
    ];
}

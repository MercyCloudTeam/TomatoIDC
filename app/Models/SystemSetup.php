<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetup extends Model
{
    use HasFactory,Cachable;

    protected $cacheCooldownSeconds = 7200;

    protected $primaryKey = 'name';
    public $incrementing = false;
    public $timestamps = false;

    protected $table = 'system_setups';

    protected $fillable = [
        'name','value','type'
    ];

    public static function updateSetup(string $name,string $value,string $type)
    {
        SystemSetup::updateOrInsert([
            'name'=>$name
        ],
        [
           'value'=>$value,
           'type'=>$type,
        ]);
    }
    public static function setup(string $name)
    {
        return SystemSetup::find($name)->value ?? null;
    }


}

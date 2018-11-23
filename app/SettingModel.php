<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table = 'settings';
    protected $fillable = ['name', 'value'];


}

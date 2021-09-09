<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}

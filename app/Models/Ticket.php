<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
	use HasDateTimeFormatter;
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'title','content','contact','type','priority','user_id','service_id','admin_id','status'
    ];

    /**
     * 用户模型绑定
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodConfigureModel extends Model
{
    protected $table = 'goods_configure';

    protected $fillable = [
        'title',
        'qps',
        'php_version',
        'mysql_version',
        'db_quota',
        'domain',
        'max_connect',
        'max_worker',
        'doc_root',
        'web_quota',
        'speed_limit',
        'log_handle',
        'subdir',
        'subdir_flag',
        'db_type',
        'type',
        'flow_limit',
        'max_subdir',
        'time',
        'ftp',
        'template',
        'config_template',
        'free_domain',
        'language',
        'useregns',
        'hasuseregns',
        'forcedns',
        'reseller',
        'maxsql',
        'cgi',
        'maxftp',
        'maxpop',
        'maxpark',
        'maxaddon',
        'customip',
    ];

    public function getGood()
    {
        return $this->hasMany('App\GoodModel', 'configure_id', 'id');
    }
}

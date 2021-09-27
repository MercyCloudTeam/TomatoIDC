<?php

return [
    'theme'=>env('HSTACK_USER_THEME','tabler'),
    'system'=>[
        'setups'=>[
            //默认加载进缓存 key=>后台管理看到的易读项，支持多语言
            'site_title'=>'admin.title',
            'site_subtitle'=>'admin.subtitle',
            'site_keywords'=>'admin.keywords',
            'site_logo'=>'admin.logo',
            'site_logo_mini'=>'admin.logo-mini',
            'site_power_by'=>'admin.power_by',//版权显示
        ]
    ],
    'limit'=>[
        'ticket_open'=>10,//同时开启的工单
        'ticket_reply'=>100,//工单最多回复次数
        'web_per_minute'=>50,//WEB访问每分钟请求限制
        'api_per_minute'=>25,//API访问每分钟请求限制
    ],
    'dev'=>[
        'theme_json_cache' => true
    ],

];

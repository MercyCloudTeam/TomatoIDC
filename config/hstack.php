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
            'site_logo-mini'=>'admin.logo-mini',
        ]
    ],
    'limit'=>[
        'ticket_open'=>10,//同时开启的工单
        'ticket_reply'=>100,//工单最多回复次数
        'web_per_minute'=>50,//WEB访问每分钟请求限制
        'api_per_minute'=>25,//API访问每分钟请求限制
    ]
];

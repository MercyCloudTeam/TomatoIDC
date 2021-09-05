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
    ]

];

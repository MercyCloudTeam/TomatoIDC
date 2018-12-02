<?php

return [
    // Default app name
    'default_app' => 'default',

    // Base configuration
    'base' => [
        'debug' => true,
        'log' => [
            'name' => 'youzan',
            'file' => __DIR__.'/youzan.log',
            'level'      => 'debug',
            'permission' => 0777,
        ]
    ],

    // Applications
    'apps' => [
        'default' => [
            'client_id' => 'XXXXXXXXX',
            'client_secret' => 'XXXXXXXXX',
            'kdt_id' => '10000000', // store_id
        ],
        // 'another_app' => [
        //     'client_id' => 'XXXXXXXXX',
        //     'client_secret' => 'XXXXXXXXX',
        //     'redirect_uri' => 'http://YOURSITE.com/',
        // ],
        //
        // 'platform_app' => [
        //     'client_id' => '',
        //     'client_secret' => '',
        //     'type' => \Hanson\Youzan\Youzan::PLATFORM,
        // ],
    ]
];
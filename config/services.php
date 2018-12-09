<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    'directmail' => [
        'key' => null,
        'address_type' => 1,
        'from_alias' => null,
        'click_trace' => 0,
        'version' => '2015-11-23',
        'region_id' => null,
    ],

    'mailgun' => [
        'domain' => null,
        'secret' => null,
    ],

    'ses' => [
        'key' => null,
        'secret' => null,
        'region' => null,
    ],

    'sparkpost' => [
        'secret' => null,
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],



];

<?php

/**
 * Wechat Routes
 */

Route::any('api','Wechat\WechatController@wechatApi');
//http://localhost/wechat/oauth


Route::middleware(['auth','throttle:60,1'])->group(function (){
    Route::get('oauth','Wechat\WechatController@oauthApi')->name('wechat.oauth');
    Route::get('oauth/user/callback','Wechat\WechatController@oauthCallbackApi');
});
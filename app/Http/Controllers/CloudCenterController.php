<?php

namespace App\Http\Controllers;

/**
 * 后期更新的云中心预留文件
 * 获取更新，检测版本号， 协助社区发展
 */

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class CloudCenterController extends Controller
{
    //云中心连接
    //请不要做个伪云中心服务器:)
    protected $serverUrl = "api.localhost.com";
    protected $protocol = 'http'; //HTTP/HTTPS

    //获取云中心URL
    protected function serverUrl( $serverUrl ="localhost",$protocol = "http")
    {
        return $protocol . "://" . $serverUrl;
    }

    protected function clientCloudGet($url){
        $client = new Client([
            'base_uri' => $this->serverUrl(),
            'timeout'  => 5.0,
        ]);
        $response = $client->get($url);
        return $response;
    }

    protected function makeEncrypt()
    {
        $rand = md5(config('app.name').time().mt_rand(0,9999).date('y'));
        $encrypt = encrypt($rand);
    }

    public function getCloudVersion()
    {
        $this->clientCloudGet('/version');
    }

    public function getCloudUpdateLog()
    {
        $this->clientCloudGet('/version/update/Log');
    }

}

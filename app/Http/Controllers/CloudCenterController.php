<?php

namespace App\Http\Controllers;

/**
 * 后期更新的云中心预留文件
 * 获取更新，检测版本号， 协助社区发展
 */

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Yansongda\Pay\Log;


class CloudCenterController extends Controller
{
    //云中心连接
    //请不要做个伪云中心服务器:)
    protected $serverUrl = "api.localhost.com";
    protected $protocol  = 'https'; //HTTP/HTTPS

    //获取云中心URL
    protected function serverUrl($serverUrl = "localhost", $protocol = "http")
    {
        return $protocol . "://" . $serverUrl;
    }

    protected function clientCloudGet($url)
    {
        try {
            $client   = new Client(
                [
                    'base_uri' => $this->serverUrl(),
                    'timeout'  => 5.0,
                ]
            );
            $response = $client->get($url);
        }
        catch (RequestException $e) {
            Log::error('Cloud Center connect error', [$e, $url]);
            return false;
        }
        return $response;
    }

    protected function makeEncrypt()
    {
//        $encrypt = encrypt();
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

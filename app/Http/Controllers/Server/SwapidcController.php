<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SwapidcController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type = "vm"; //服务器插件类型


    //    protected function
    protected $suffix = '/api/index.php';
    protected $protocol = 'http://';


    public function resetPassHost($server, $host)
    {
        if (empty($host->panel_id)) {
            return false;
        }

        $params = [
            'form_params' => [
                'action' => 'resetPassHost',
                'order' => $host->panel_id
            ]
        ];

        $result = $this->sendPost($server, $params);

        $result = json_decode($result);
        if (!empty($result)) {
            if ($result->status == 'success') {
                HostModel::where('id', $host->id)->update(['host_pass' => $result->msg->密码]);
                return $host;
            }
        }
        Log::error('swapidc reset Pass Host error', [$result, $params, $host]);
        return false;
    }

    /**
     * 获取URL
     * @param $server
     * @return string
     */
    protected function getUrl($server)
    {
        $port = $server->port ?? "80";
        //判断是否填写前缀
        preg_match("/(http|https):\/\//", $server->ip, $arr);
        if (empty($arr)) {
            $protocol = "http://";
        } else {
            $protocol = '';
        }
        return $url = $protocol . $server->ip . ':' . $port;
    }

    /**
     * 获取服务器状态 成功返回 接口值 失败返回false
     * @param $server
     * @return bool|mixed
     */
    public function serverStatus($server)
    {

    }

    protected function sendPost($server, $params)
    {
        $publicParams = [
            'form_params' => [
                'ownerUser' => $server->username,
                'ownerPass' => $server->password,
            ],
            'verify' => false //不验证证书
        ];
        $arr = array_merge_recursive($publicParams, $params);
//        dd($arr);
        $url = $this->getUrl($server) . '/index.php/plugin/reseller/api';
        try {
            $client = new Client();
            $resp = $client->request('POST', $url, $arr);
        } catch (RequestException $e) {
            Log::error('Swapidc error ', [$e, $params]);
            return false;
        }
        return $resp->getBody()->getContents();
    }


    /**
     * 永久删除主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function terminateHost($server, $host)
    {
        if (empty($host->panel_id)) {
            return false;
        }

        $params = [
            'form_params' => [
                'action' => 'terminateHost',
                'order' => $host->panel_id
            ]
        ];

        $result = $this->sendPost($server, $params);
        $result = json_decode($result);
        if (!empty($result)) {
            if ($result->status == 'success') {
                return $host;
            }
        }
        Log::error('swapidc change status error', [$result, $params, $host]);
        return false;
    }

    /**
     * 创建主机
     * @param $server
     * @param $configure
     * @param $order
     * @return bool
     */
    public function createHost($server, $configure, $order)
    {
        !$order->domain ? $domain = str_random(10) . ".com" : $domain = $order->domain;
        $params = [
            'form_params' => [
                'action' => 'createHost',
                'domain' => $domain,
                'goodsName' => $configure->config_template,
            ]
        ];

        $result = $this->sendPost($server, $params);

        $result = json_decode($result);
        if (!empty($result)) {
//            dd($result);
            if ($result->status == 'success') {
                $host = HostModel::create(
                    [
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'host_name' => $result->msg->用户名,
                        'host_pass' => $result->msg->密码,
                        'host_panel' => 'Swapidc',
                        'host_url' => null
                    ]
                );

                HostModel::where('id',$host->id)->update(['panel_id'=>$result->msg->id]);
                return $host;
            }
        }
        Log::error('swapidc create host err ', [$result, $server]);
        return false;
    }


    /**
     * 主机面板管理
     * @param $server
     * @param $host
     * @return bool|array
     */
    public function managePanelLogin($server, $host)
    {
        return false;
    }

    /**
     * 续费主机
     * @return bool
     */
    public function renewHost($server, $configure, $order, $host)
    {
        $params = [
            'form_params' => [
                'action' => 'renewHost',
                'goodsName' => $host->server_id,
                'order'=>$host->panel_id
            ]
        ];
        $result = $this->sendPost($server, $params);
        $result = json_decode($result);
        if (!empty($result)) {
//            dd($result);
            if ($result->status == 'success') {
                return $host;
            }
        }
        Log::error('swapidc renew host err ', [$result, $server]);
        return false;
    }

    /**
     * 更改用户状态
     * @param $server
     * @param $hostsettings
     * @param $status
     * @return bool|string
     */
    protected function changeUserStatus($server, $host, $status)
    {
        switch ($status) {
            case 1:
                $action = 'openHost';
                break;
            case 0:
                $action = 'closeHost';
                break;
            default:
                return false;
        }

        if (empty($host->panel_id)) {
            return false;
        }

        $params = [
            'form_params' => [
                'action' => $action,
                'order' => $host->panel_id
            ]
        ];
        $result = $this->sendPost($server, $params);
        $result = json_decode($result);
        if (!empty($result)) {
            if ($result->status == 'success') {
                return $host;
            }
        }
        Log::error('swapidc change status error', [$result, $params, $host]);
        return false;
    }

    /**
     * 开通主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function openHost($server, $host)
    {
        return $this->changeUserStatus($server, $host, 1);
    }

    /**
     * 停用主机
     * @param $server
     * @param $host
     * @return false|object
     */
    public function closeHost($server, $host)
    {
        return $this->changeUserStatus($server, $host, 0);
    }
}

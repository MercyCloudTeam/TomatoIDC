<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class ProxmoxController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type             = true; //服务器插件类型

    /**
     * 获取服务器状态 成功返回 接口值 失败返回false
     * @param $server
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function serverStatus($server)
    {
        $result = $this->clientApi($server, 'GET', '/api2/json/nodes');
//                dd(json_decode($result));
        return false;
    }

    /**
     * 向服务器发送请求
     * @param $server ServerModel
     * @param $method string GET|POST
     * @param $action string url
     * @param null $configure
     * @param null $param
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function clientApi($server, $method, $action, $configure = null, $param = null)
    {
        $url    = $this->getUrl($server);
        $ticket = $this->getTicket($server, $configure);
        if (empty($ticket)) {
            return false;
        }

        $cookies = [
            'PVEAuthCookie'       => $ticket->data->ticket,
            'CSRFPreventionToken' => $ticket->data->CSRFPreventionToken,
        ];
//        try {
            $cookieJar     = CookieJar::fromArray($cookies, $server->ip);
            $public_params = [
                'verify'      => false, //不验证证书
                'cookies'     => $cookieJar,
                'form_params' => [
//                    'CSRFPreventionToken' => $ticket->data->CSRFPreventionToken,
                ],
                'headers'     => [
                    'CSRFPreventionToken' => $ticket->data->CSRFPreventionToken,
                ]
            ];
            if (!empty($param)) {
                $params = array_merge_recursive($public_params, $param);
            } else {
                $params = $public_params;
            }
            //            dd($params);
            $client   = new Client();
            $response = $client->request(
                $method, $url . $action, $params
            );
//        }
//        catch (RequestException $e) {
//            Log::error('Proxmox  RequestException error', [$e, $server, $url, $cookies, $param]);
//            return false;
//        }

        if (!empty($response->getBody()->getContents())) {
            return (string)$response->getBody();
        }
        Log::error('Proxmox result error', [$response, $server, $url, $cookies, $param]);
        return false;
    }

    protected function createUserPve($server)
    {
        $param['form_params']['userid'] = strtolower('test');
        $result                         = $this->clientApi($server, 'POST', '/api2/json/access/users', null, $param);
        dd($result);
        // /api2/json/access/users

    }

    //https://your.server:8006/api2/json/

    protected function getTicket($server, $configure)
    {
        $url   = $this->getUrl($server) . "/api2/json/access/ticket";
        $realm = $server->key2 ?? "pam";
        $arr   = [
            'form_params' => [
                'username' => $server->username,
                'password' => $server->password,
                'realm'    => $realm,
            ],
            'verify'      => false //不验证证书
        ];
        try {
            $client   = new Client();
            $response = $client->request('POST', $url, $arr);
        }
        catch (\Exception $e) {
            Log::error('Proxmox get ticket error', [$server, $url, $arr]);
            return false;
        }
        $result = $response->getBody()->getContents();
        if (!empty($result)) {
            return $result = json_decode($result);
        }
        return false;
    }

    protected function getUrl($server)
    {
        $port = $server->port ?? "8006";
        //判断是否填写前缀
        preg_match("/(http|https):\/\//", $server->ip, $arr);
        if (empty($arr)) {
            $protocol = "https://";
        } else {
            $protocol = '';
        }
        return $url = $protocol . $server->ip . ':' . $port;
    }

    /**
     * 创建主机
     * @param $server
     * @param $configure
     * @param $order
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createHost($server, $configure, $order)
    {
//        $this->createUserPve($server);
        $node = $configure->customip ?? "pve";
        $osTemplate = $configure->template ?? null;
        $vmid = mt_rand(10,99).substr(time(),7).mt_rand(100,999);
        $param['form_params']=[
            'ostemplate'=>$osTemplate,
            'vmid'=>$vmid
        ];
        $this->clientApi($server,'POST',' /api2/json/nodes/'.$node.'/lxc',null,$param);

        dd(json_decode($this->clientApi($server, 'GET', '/api2/json/nodes', $configure)));
        $host = HostModel::create(
            [
                'order_id'   => $order->id,
                'user_id'    => $order->user_id,
                'host_name'  => $order->good->title,
                'host_pass'  => 'null',
                'host_panel' => 'null',
                'host_url'   => 'null'
            ]
        );
        return $host;
    }

    //TODO 获取主机信息
    public function getVh($server, $host)
    {

    }

    /**
     * 续费主机
     * @return bool
     */
    public function renewHost()
    {
        return true;
    }

    /**
     * 开通主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function openHost($server, $host)
    {
        return $host;
    }

    /**
     * 停用主机
     * @param $server
     * @param $host
     * @return false|object
     */
    public function closeHost($server, $host)
    {
        return $host;
    }
}

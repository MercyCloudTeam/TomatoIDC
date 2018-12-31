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

class CyberPanelController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type             = "vm"; //服务器插件类型


    //    protected function
    protected $suffix   = '/api/index.php';
    protected $protocol = 'http://';

    /**
     * 获取服务器状态 成功返回 接口值 失败返回false
     * @param $server
     * @return bool|mixed
     */
    public function serverStatus($server)
    {

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
        $username = str_random(8);
        $password = str_random();
        !$order->domain ? $domain = $username . time() . ".com" : $domain = $order->domain;
        $params = [
            'domainName'    => $domain,
            'ownerEmail'    => $order->user->email,
            'packageName'   => $configure->config_template,
            'websiteOwner'  => $username,
            'ownerPassword' => $password,
        ];
        try {
            $resp = $this->sendPost('createWebsite', $params, $server);
        }
        catch (\Exception $e) {
            Log::error("cyberpanel error ", [$e]);
            return false;
        }
        if (!$resp['createWebSiteStatus']) {
            Log::error('cyberPanel create host error', [$resp, $server]);
            return false;
        }
        $host = HostModel::create(
            [
                'order_id'   => $order->id,
                'user_id'    => $order->user_id,
                'host_name'  => $username,
                'host_pass'  => $password,
                'host_panel' => 'CyberPanel',
                'host_url'   => null
            ]
        );
        OrderModel::where('id', $order->id)->update(['domain' => $domain]);
        return $host;
    }


    /**
     * 发送请求
     * @param $action
     * @param array $post
     * @param $server
     * @return bool|mixed|string
     */
    protected function sendPost($action, $post = array(), $server)
    {
        $publicParams = [
            "adminUser" => $server->username,
            "adminPass" => $server->password
        ];

        $params = array_merge_recursive($publicParams, $post);

        $call = curl_init();
        curl_setopt($call, CURLOPT_URL, $this->getUrl($server) . '/api/' . $action);
        curl_setopt($call, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($call, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($call, CURLOPT_POST, true);
        curl_setopt($call, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($call, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($call, CURLOPT_SSL_VERIFYPEER, false);

        // Fire api
        $result = curl_exec($call);
        $info   = curl_getinfo($call);
        curl_close($call);
        $result = json_decode($result, true);

        // Return data
        return $result;
    }

    /**
     * 获取url
     * @param $server
     * @return string
     */
    protected function getUrl($server)
    {
        $port = $server->port ?? "8090";
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
     * 主机面板管理
     * @param $server
     * @param $host
     * @return array
     */
    public function managePanelLogin($server, $host)
    {
        $url    = $this->getUrl($server);
        $input  = '
        <form class="cyberpanel" action="' . $url . '/api/loginAPI" method="post">
        <input type="hidden" name="username" value="' . $host->host_name . '" />
        <input type="hidden" name="password" value="' . $host->host_pass . '" />
        <input type="submit"  id="login" value="Login to Control Panel" />
        </form>
        <script>
              setTimeout(function(){
                  var login = document.getElementById(\'login\');//给你的a标签加一个id 
                  login.click();
              },200);
        </script>
        ';
        $base64 = base64_encode($input);
        return ['type' => 'from_base64', 'content' => $base64];
    }

    /**
     * 续费主机
     * @return bool
     */
    public function renewHost($server, $configure, $order)
    {
        //        OrderModel::where($server->order)
        return true;
    }

    /**
     * 重置密码
     * @param $server
     * @param $host
     * @return mixed
     */
    public function resetPassHost($server, $host)
    {
        $password = str_random();
        $params
                  = [
            "websiteOwner"  => $host->host_name,
            "ownerPassword" => $password
        ];
        try {
            $resp = $this->sendPost('changeUserPassAPI', $params, $server);
        }
        catch (\Exception $e) {
            Log::error("cyberpanel error ", [$e]);
            return false;
        }
        if (!$resp['changeStatus']) {
            Log::error('cyberPanel terminateHost error', [$resp, $server]);
            return false;
        }
        HostModel::where('id', $host->id)->update(['host_pass' => $password]);
        return $host;
    }

    /**
     * 永久删除主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function terminateHost($server, $host)
    {
        $params = [
            "domainName" => $host->order->domain,
        ];
        try {
            $resp = $this->sendPost('deleteWebsite', $params, $server);
        }
        catch (\Exception $e) {
            Log::error("cyberpanel error ", [$e]);
            return false;
        }
        if (!$resp['websiteDeleteStatus']) {
            Log::error('cyberPanel terminateHost error', [$resp, $server]);
            return false;
        }
        //        Log::info('data', [$resp]);
        return $host;
    }

    /**
     * 更改用户状态
     * @param $server
     * @param $host
     * @param $status
     * @return bool|string
     */
    protected function changeAccountStatus($server, $host, $status)
    {
        switch ($status) {
            case 1:
                $action = 'Unsuspend';
                break;
            case 0:
                $action = 'Suspend';
                break;
            default:
                return false;
        }
        $params = [
            "websiteName" => $host->order->domain,
            "state"       => $action
        ];
        try {
            $resp = $this->sendPost('submitWebsiteStatus', $params, $server);
        }
        catch (\Exception $e) {
            Log::error("cyberpanel error ", [$e]);
            return false;
        }
        if (!$resp['websiteStatus']) {
            Log::error('cyberPanel changeAccountStatus error', [$resp, $server]);
            return false;
        }
        //        Log::info('data', [$resp]);
        return $host;
    }

    /**
     * 开通主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function openHost($server, $host)
    {
        return $this->changeAccountStatus($server, $host, 1);
    }

    /**
     * 停用主机
     * @param $server
     * @param $host
     * @return false|object
     */
    public function closeHost($server, $host)
    {
        return $this->changeAccountStatus($server, $host, 0);
    }
}

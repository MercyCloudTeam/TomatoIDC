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

class VestaController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type             = "vm"; //服务器插件类型


    //    protected function
    protected $suffix   = '/api/index.php';
    protected $protocol = 'http://';


    public function resetPassHost($server, $host)
    {
        $password = str_random();
        $params = [
            'form_params'=>[
                'cmd'=>'v-change-user-password',
                'arg1'=>$host->host_name,
                'arg2'=>$password
            ]
        ];
        $result = $this->sendPost($server,$params);
        if ($result !== false){
            if ($result == 0){
                HostModel::where('id',$host->id)->update(['host_pass'=>$password]);
                return $host;
            }
        }
    }

    /**
     * 获取URL
     * @param $server
     * @return string
     */
    protected function getUrl($server)
    {
        $port = $server->port ?? "8083";
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
                'user'       => $server->username,
                'password'   => $server->password,
                'returncode' => 'yes',
            ],
            'verify'      => false //不验证证书
        ];
        $arr          = array_merge_recursive($publicParams, $params);
        $url          = $this->getUrl($server) . '/api/';
        try {
            $client = new Client();
            $resp   = $client->request('POST', $url, $arr);
        }
        catch (RequestException $e) {
            Log::error('Vesta error ', [$e, $params]);
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
        $params = [
            'form_params' => [
                'cmd'  => 'v-delete-user',
                'arg1' => $host->host_name
            ]
        ];
        $result = $this->sendPost($server, $params);
        if ($result !== false) {
            if ($result == 0) {
                return $host;
            }
        }
        Log::error('Vesta terminate Host err ', [$result, $host, $server]);
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
        $username = str_random(10);
        $password = str_random();
        $params   = [
            'form_params' => [
                'cmd'  => 'v-add-user',
                'arg1' => $username,
                'arg2' => $password,
                'arg3' => $order->user->email,
                'arg4' => $configure->config_template,
                'arg5' => substr($username, 0, 5),
                'arg6' => substr($username, 5)
            ]
        ];
        $result   = $this->sendPost($server, $params);
        if ($result !== false) {
            if ($result == 0) {
                $host = HostModel::create(
                    [
                        'order_id'   => $order->id,
                        'user_id'    => $order->user_id,
                        'host_name'  => $username,
                        'host_pass'  => $password,
                        'host_panel' => 'Vesta',
                        'host_url'   => null
                    ]
                );
                return $host;
            }
        }
        Log::error('Vesta create host err ', [$result, $server]);
        return false;
    }


    /**
     * 主机面板管理
     * @param $server
     * @param $host
     * @return array
     */
    public function managePanelLogin($server, $host)
    {
        $url = $this->getUrl($server);
        //        dd($url);
        $input = '
            <form action=" ' . $url . '/login/" method="post" >
            <input type="hidden" name="user" value="' . $host->host_name . '" />
            <input type="hidden" name="password" value="' . $host->host_pass . '" />
            <input type="submit" id="login" value="Login" />
            </form>
            <script>
              setTimeout(function(){
                  var login = document.getElementById(\'login\');
                  login.click();
              },100);
            </script>
        ';
        $base64 = base64_encode($input);
        return ['type' => 'from_base64', 'content' => $base64];
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
     * 更改用户状态
     * @param $server
     * @param $host
     * @param $status
     * @return bool|string
     */
    protected function changeUserStatus($server, $host, $status)
    {
        switch ($status) {
            case 1:
                $cmd = 'v-unsuspend-user';
                break;
            case 0:
                $cmd = 'v-suspend-user';
                break;
            default:
                return false;
        }
        $params = [
            'form_params' => [
                'cmd'  => $cmd,
                'arg1' => $host->host_name
            ]
        ];
        $result = $this->sendPost($server, $params);
        if ($result !== false) {
            if ($result == 0) {
                return $host;
            }
        }
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

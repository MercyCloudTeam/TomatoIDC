<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class EasyPanelController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type             = "vm"; //服务器插件类型

    /**
     * CURL GET请求
     * @param $url string 请求URL
     * @return mixed 返回获取信息
     */
    protected function curlGet($url)
    {
        $ch = curl_init();  //初始化一个cURL会话
        curl_setopt($ch, CURLOPT_URL, $url);//设置需要获取的 URL 地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//不返回数据
        if (empty($result = curl_exec($ch))) {
            return false;
        };//执行一个cURL会话
        return $result;
    }

    /**
     *
     * @return null
     */
    public function makeGetUrl()
    {
        $server = ServerModel::where(
            [
                ['status', '!-', '0'],
                ['plugin', 'easypanel'],
                //            ['id',$id]
            ]
        )->get()
        ;
        !$server->isEmpty() ?: $server = null;
        return $server;
    }

    /**
     * 生成签名
     * @param $action
     * @param $key
     * @param $rand
     * @return string
     */
    protected function makeSign($action, $key, $rand)
    {
        return md5($action . $key . $rand);
    }

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
        !empty($server->port) ? $port = $server->port : $port = "3312" . $this->suffix;
        $serverUrl = $server->ip;
        $rand      = mt_rand(1000, 9999);
        $url       = $this->protocol . $serverUrl . ":" . $port . '?c=whm&a=info&json=1&r=' . $rand . '&s=' . $this->makeSign('info', $server->key, $rand);
        $result    = $this->curlGet($url);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['result'] == '200') {
                $back = [];
                empty($result['type'][0][0]) ? $back['type'] = null : $back['type'] = $result['type'][0][0];
                empty($result['os'][0][0]) ? $back['os'] = null : $back['os'] = $result['os'][0][0];
                empty($result['server'][0][0]) ? $back['server'] = null : $back['server'] = $result['server'][0][0];
                empty($result['version'][0][0]) ? $back['version'] = null : $back['version'] = $result['version'][0][0];
                empty($result['disk_free'][0][0]) ? $back['disk_free'] = null : $back['disk_free'] = $result['disk_free'][0][0];
                empty($result['connect'][0][0]) ? $back['connect'] = null : $back['connect'] = $result['connect'][0][0];
                empty($result['total_run'][0][0]) ? $back['total_run'] = null : $back['total_run'] = $result['total_run'][0][0];
                return $back;
            }
            return false;
        };
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
        !empty($server->port) ? $port = $server->port : $port = "3312" . $this->suffix;
        $serverUrl    = $server->ip;
        $rand         = mt_rand(1000, 9999);
        $sign         = $this->makeSign('add_vh', $server->key, $rand);
        $name         = date('y') . $rand . substr(time(), 4);
        $password     = substr(md5($rand . $configure->title . time() . $serverUrl), 16);
        $configureUrl = '&json=1';
        // 判断设置是否存在 ? 默认值（可空）: 连接
        //构建URL请求接口URL
        //http://www.kanglesoft.com:3312/api/?c=whm&a=add_vh&r=3333&s=sdfasdfsadfddaffsdf3&name=webtest&passwd=webpasswd&init=1&product_name=php100
        !$configure->web_quota ?: $configureUrl .= "&web_quota=" . $configure->web_quota;
        !$configure->db_quota ?: $configureUrl .= "&db_quota=" . $configure->db_quota;
        !$configure->ftp ? $configureUrl .= "&ftp=-1" : $configureUrl .= "&ftp=" . (int)$configure->ftp;
        !$configure->subdir ? $configureUrl .= "&subdir=wwwroot" : $configureUrl .= "&subdir=" . $configure->subdir;
        !$configure->domain ? $configureUrl .= "&domain=-1" : $configureUrl .= "&domain=" . $configure->domain;
        !$configure->subdir_flag ? $configureUrl .= "&subdir_flag=1" : $configureUrl .= "&subdir_flag=" . (int)$configure->subdir_flag;
        !$configure->max_subdir ? $configureUrl .= "&subdir_flag=0" : $configureUrl .= "&max_subdir=" . $configure->max_subdir;
        !$configure->db_type ?: $configureUrl .= "&db_type=" . $configure->db_type;
        !$configure->templete ? $configureUrl .= "&templete=php" : $configureUrl .= "&templete=" . $configure->templete;
        !$configure->module ? $configureUrl .= "&module=php" : $configureUrl .= "&module=" . $configure->module;
        !$configure->mysql_verison ?: $configureUrl .= "&subtemplete=" . $configure->mysql_verison;

        if (!empty($configure->config_template)) {//使用模板开通
            $configureUrl = "&product_name=" . $configure->config_template;
        }

        $url    = $this->protocol . $serverUrl . ':' . $port . '?c=whm&a=add_vh&r=' . $rand . '&s=' . $sign . "&name=" . $name . "&passwd=" . $password . "&init=1" . $configureUrl;
        $result = $this->curlGet($url);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['result'] == 200) {
                $tempPort = !empty($server->port) ? $server->port : ":3312/vhost/";
                $host     = HostModel::create(
                    [
                        'order_id'   => $order->id,
                        'user_id'    => $order->user_id,
                        'host_name'  => $name,
                        'host_pass'  => $password,
                        'host_panel' => 'EasyPanel',
                        'host_url'   => $this->protocol . $serverUrl . $tempPort
                    ]
                );
                return $host;
            }
            Log::info('EasyPanel Create Host Errror', ['url' => $url]);
            return false;
        }
        return false;
    }

    //TODO 获取主机信息
    public function getVh($server, $host)
    {
        !empty($server->port) ? $port = $server->port : $port = "3312" . $this->suffix;
        $serverUrl = $server->ip;
        $rand      = mt_rand(1000, 9999);
        $sign      = $this->makeSign('add_vh', $server->key, $rand);
        $url       = $this->protocol . $serverUrl . ':' . $port . "";
    }

    /**
     * 续费主机
     * ep面板没法限定时间
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
        !empty($server->port) ? $port = $server->port : $port = "3312" . $this->suffix;
        $serverUrl = $server->ip;
        $rand      = mt_rand(1000, 9999);
        $sign      = $this->makeSign('update_vh', $server->key, $rand);
        $url       = $this->protocol . $serverUrl . ':' . $port . "?c=whm&a=update_vh&&r=" . $rand . "&s=" . $sign . "&name=" . $host->host_name . "&status=0&json=1";
        $result    = $this->curlGet($url);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['result'] == 200) {
                return $host;
            }
            Log::info('EasyPanel close host error', ['url' => $url]);
            return false;
        }
        return false;
    }

    /**
     * 停用主机
     * @param $server
     * @param $host
     * @return false|object
     */
    public function closeHost($server, $host)
    {
        !empty($server->port) ? $port = $server->port : $port = "3312" . $this->suffix;
        $serverUrl = $server->ip;
        $rand      = mt_rand(1000, 9999);
        $sign      = $this->makeSign('update_vh', $server->key, $rand);
        $url       = $this->protocol . $serverUrl . ':' . $port . "?c=whm&a=update_vh&&r=" . $rand . "&s=" . $sign . "&name=" . $host->host_name . "&status=1&json=1";
        $result    = $this->curlGet($url);
        if ($result) {
            $result = json_decode($result, true);
            if ($result['result'] == 200) {
                return $host;
            }
            Log::info('EasyPanel close host error', ['url' => $url]);
            return false;
        }
        return false;
    }
}

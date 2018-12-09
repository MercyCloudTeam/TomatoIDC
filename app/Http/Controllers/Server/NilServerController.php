<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class NilServerController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type = true; //服务器插件类型

    /**
     * 获取服务器状态 成功返回 接口值 失败返回false
     * @param $server
     * @return bool|mixed
     */
    public function serverStatus($server)
    {
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
                $host = HostModel::create([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'host_name' => $order->good->title,
                    'host_pass' => 'null',
                    'host_panel' => 'null',
                    'host_url' => 'null'
                ]);
                return $host;
    }

    //TODO 获取主机信息
    public function getVh($server, $host)
    {
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
    public function openHost($server,$host)
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

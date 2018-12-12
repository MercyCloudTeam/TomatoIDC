<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServerPluginController extends Controller
{
    /**
     * 获取服务器插件
     * @return array
     */
    public static function getServerPluginArr()
    {
        $path = app_path('Http/Controllers/Server/');
        $fileTemp = scandir($path);
        $fileList = [];
        foreach ($fileTemp as $value) {
            if ($value != '.' && $value != '..' && $value != "ServerPluginController.php") {
                $value = str_replace('Controller.php', '', $value);//排除后缀
                array_push($fileList, $value);
            }
        }
        return $fileList;
    }


    /**
     * 快捷登录管理员面板
     * @param $server
     * @param $host
     * @return bool
     */
    public function managePanelLogin($server,$host)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        if (method_exists($plugin,'managePanelLogin')){
            return $plugin->managePanelLogin($server,$host);
        }
        return false;
    }

    public function getServerPluginForm()
    {

    }

    /**
     * 获取服务器状态
     * @param $server
     * @return mixed
     */
    public function serverStatus($server)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        return $plugin->serverStatus($server);

    }

    /**
     * 创建主机
     * @param $server
     * @param $configure
     * @param $order
     * @return mixed
     */
    public function createHost($server, $configure, $order)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        return $plugin->createHost($server, $configure, $order);
    }

    /**
     * 续费主机
     * @param $server
     * @param $configure
     * @param $order
     * @param null $host
     * @return mixed
     */
    public function renewHost($server, $configure, $order, $host = null)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        return $plugin->renewHost($server, $configure, $order);
    }

    /**
     * 关闭主机
     * @param $server
     * @param $host
     * @return mixed
     */
    public function closeHost($server, $host)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        return $plugin->closeHost($server, $host);
    }

    public function openHost($server, $host)
    {
        $controllerName = __NAMESPACE__ . '\\' . $server->plugin . "Controller";
        $plugin = new $controllerName();
        return $plugin->openHost($server, $host);
    }

}

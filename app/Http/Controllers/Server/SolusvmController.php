<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class SolusvmController extends Controller
{

    public $diyConfigureFrom = false;//使用自定义表单
    public $type             = true; //服务器插件类型

    /**
     * 获取服务器状态 成功返回 接口值 失败返回false
     * @param $server
     * @return bool|mixed
     */
    public function serverStatus($server)
    {
        return false;
    }

    protected $protocol = 'https://';


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
        if (empty($server->port)) {
            $server->port = 5656;
        }
        //被坑*2
        $url      = $this->protocol . $server->ip . ":" . $server->port . "/api/admin/command.php";
        $username = str_random(8);
        $password = str_random();

        $params = [ //公用提交
                    'form_params' => [
                        'rdtype' => 'json',
                        'key'    => $server->key,
                        'id'     => $server->token,
                    ],
                    'verify'      => false //不验证证书
        ];

        //创建用户
        $clientArr = [
            'form_params' => [
                'action'    => 'client-create',
                'firstname' => substr($username, 0, 4),
                'lastname'  => substr($username, 4),
                'username'  => $username,
                'password'  => $password,
                'email'     => $order->user->email,
            ],
        ];
        $clientArr = array_merge_recursive($clientArr, $params);
        try {
            $client = new Client(['timeout' => 60]);
            //记录个坑 setDefaultOption('verify', false); 可以不验证证书，但是在GuzzleHttp 6.3中如果使用这个，那么就会出现bug 2h
            $response = $client->request(
                'POST', $url, $clientArr
            );
        }
        catch (\Exception $e) {//错误返回
            Log::error('Solusvm create client error', [$e, $server, $order]);
            return false;
        }
        $clientResult = $response->getBody()->getContents();
        $clientResult = json_decode($clientResult);
        if ($clientResult->status != "success") {
            Log::error('create client error', [$clientResult]);
            return false;
        }


        $hostname = str_random(8);

        //创建虚拟服务器
        $arr = [
            'form_params' => [
                'action'   => 'vserver-create',
                'type'     => $configure->module,
                'password' => $password,
                'username' => $username,
                'hostname' => $hostname,
                'ips'      => 1,
            ],
        ];
        if (empty($configure->config_template)) { //plan
            $arr['form_params']['custommemory']     = $configure->custommemory;
            $arr['form_params']['customdiskspace '] = $configure->web_quota;
            $arr['form_params']['custombandwidth']  = $configure->custommemory;
            $arr['form_params']['hvmt']             = $configure->hvmt;
            $arr['form_params']['customcpu']        = $configure->overover;
            $arr['form_params']['custommemory']     = $configure->custommemory;
        } else {
            $arr['form_params']['plan'] = $configure->config_template;
        }
        if (empty($configure->template)) {//template
            $arr['form_params']['template'] = 'none';
        } else {
            $arr['form_params']['template'] = $configure->template;
        }
        if (!empty($configure->customip)) {
            $arr['form_params']['node'] = $configure->customip;
        }//node
        if (!empty($configure->group)) {//node group
            $arr['form_params']['nodegroup'] = $configure->group;
        }
        if (!empty($configure->domain)) {//node group
            $arr['form_params']['ips'] = $configure->domain;
        } else {
            $arr['form_params']['ips'] = 1;
        }
        //        dd($arr);


        $arr = array_merge_recursive($params, $arr);
        //        dd($arr);
        try {

            $client = new Client(['timeout' => 60]);
            //记录个坑 setDefaultOption('verify', false); 可以不验证证书，但是在GuzzleHttp 6.3中如果使用这个，那么就会出现bug 2h
            $response = $client->request(
                'POST', $url, $arr
            );
        }
        catch (\Exception $e) {//错误返回
            Log::error('Solusvm create host error', [$e, $server, $order]);
            return false;
        }
        $result = $response->getBody()->getContents();
        $result = json_decode($result);

        if (!empty($result) && $result->status == "success") { //成功创建
            $host = HostModel::create(
                [
                    'order_id'   => $order->id,
                    'user_id'    => $order->user_id,
                    'host_name'  => $username,
                    'host_pass'  => $password,
                    'host_panel' => 'SolusVM',
                    'host_url'   => $this->protocol . $server->ip
                ]
            );
            HostModel::where('id', $host->id)->update(['server_id' => $result->vserverid]);
            return $host;
        }
        //错误返回
        Log::error('Solusvm error', [$result, $arr]);
        return false;
    }

    //TODO 获取主机信息
    public function getVh($server, $host)
    {

    }


    public function managePanelLogin($server, $host)
    {
        return false;
        //        $url      = $this->protocol . $server->ip . ":" . $server->port . "/api/admin/command.php";
        //        $params = [ //提交
        //                    'form_params' => [
        //                        'rdtype' => 'json',
        //                        'action'=>'client-key-login',
        //                        'key'    => $server->key,
        //                        'id'     => $server->token,
        //                        'returnurl'=>$this->protocol . $server->ip,
        //                        'forward '=>1,
        //                        'username'=>$host->host_name,
        //                    ],
        //                    'verify'      => false //不验证证书
        //        ];
        //
        //        try {
        //            $client = new Client(['timeout' => 60]);
        //            $response = $client->request(
        //                'POST', $url, $params
        //            );
        //        }
        //        catch (\Exception $e) {//错误返回
        //            Log::error('Solusvm client-key-logi error', [$e, $server, $host]);
        //            return false;
        //        }
        //        $data = $response->getBody()->getContents();
        //        $data = json_decode($data);
        //        if ($data->status == "success"){
        //
        //            Cookie::make('hasha',$server->hasha);
        //            Cookie::make('hashb',$server->hashb);
        //            dd($this->protocol . $server->ip);
        ////            return redirect($this->protocol . $server->ip);
        //        }
        //        dd($data);
        ////        if ($data->metadata->result) {
        ////            return $data->data->url;
        ////        }
        //        Log::error('Solusvm client-key-logi error', [$data]);
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
     * 禁用 启用主机
     * @param $status 0 =suspend  1= unsuspend
     * @param $server
     * @param $host
     * @return HostModel|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function editVirtualServerStatus($status, $server, $host)
    {
        switch ($status) {
            case 0:
                $action = "vserver-suspend";
                break;
            case 1:
                $action = "vserver-unsuspend";
                break;
            default:
                return false;
        }

        if (empty($host->server_id)) {
            //TODO 根据host_name获取服务器ID
            Log::error('Solusvm editVirtualServerStatus server id is null', [$host, $server]);
            return false;
        }

        $url    = $this->protocol . $server->ip . ":" . $server->port . "/api/admin/command.php";
        $params = [ //提交
                    'form_params' => [
                        'rdtype'    => 'json',
                        'key'       => $server->key,
                        'id'        => $server->token,
                        'action'    => $action,
                        'vserverid' => $host->server_id
                    ],
                    'verify'      => false //不验证证书
        ];

        try {

            $client   = new Client(['timeout' => 60]);
            $response = $client->request(
                'POST', $url, $params
            );
        }
        catch (\Exception $e) {//错误返回
            Log::error('Solusvm editVirtualServerStatus error', [$e, $server, $host]);
            return false;
        }

        $result = $response->getBody()->getContents();
        $result = json_decode($result);
        if (!empty($result) && $result->status == "success") { //成功
            return $host;
        }
        //错误返回
        Log::error('Solusvm editVirtualServerStatus error', [$result, $server, $host]);
        return false;
    }

    /**
     * 开通主机
     * @param $server
     * @param $host
     * @return HostModel|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function openHost($server, $host)
    {
        $status = $this->editVirtualServerStatus(1, $server, $host);
        if (empty($status)) {
            return false;
        }
        return $status;
    }

    /**
     * 停用主机
     * @param $server
     * @param $host
     * @return HostModel|bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function closeHost($server, $host)
    {
        $status = $this->editVirtualServerStatus(0, $server, $host);
        if (empty($status)) {
            return false;
        }
        return $status;
    }
}

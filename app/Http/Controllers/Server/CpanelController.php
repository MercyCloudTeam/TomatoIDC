<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use App\OrderModel;
use App\ServerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class CpanelController extends Controller
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

    //TODO 异步开通

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
        $url      = $server->ip . ":" . $server->port;
        $url      .= "/json-api/createacct?api.version=1";
        $username = strtolower('t' . str_random(4) . mt_rand(0, 999));
        !$order->domain ? $domain = $username . time() . ".com" : $domain = $order->domain;
        $password = str_random(12);
        !$order->user->email ? $email = str_random(5) . "example@email.com" : $email = $order->user->email;
        $owner = $server->username;
        !$configure->speed_limit ? $bwlimit = 500 : $bwlimit = $configure->speed_limit;
        !$configure->language ? $language = "en" : $language = $configure->language;
        !$configure->template ? $cpmod = "paper_lantern" : $cpmod = $configure->template;
        !$configure->web_quota ? $quoto = 0 : $quoto = $configure->web_quota;
        !$configure->maxftp ? $maxftp = 1 : $maxftp = $configure->maxftp;
        !$configure->maxsql ? $maxsql = 1 : $maxsql = $configure->maxsql;
        !$configure->reseller ? $reseller = 0 : $reseller = $configure->reseller;
        !$configure->maxpop ? $maxpop = 1 : $maxpop = $configure->maxpop;
        !$configure->cgi ? $cgi = 1 : $cgi = $configure->cgi;
        !$configure->useregns ? $useregns = 1 : $useregns = $configure->useregns;
        !$configure->hasuseregns ? $hasuseregns = 1 : $hasuseregns = $configure->hasuseregns;

        $url .= "
            &username=" . $username . "
            &domain=" . $domain;
        if (!empty($configure->config_template)) {//使用模板开通
            $url .= "&plan=" . $configure->config_template;
        }
        else {
            $url .= "
            &featurelist=default
            &quota=" . $quoto . "
            &password=" . $password . "
            &ip=n
            &cgi=1" . $cgi . "
            &hasshell=0
            &contactemail=" . $email . "
            &cpmod=" . $cpmod . "
            &maxftp=" . $maxftp . "
            &maxsql=" . $maxsql . "
            &maxpop=" . $maxpop . "
            &maxlst=5
            &maxsub=1
            &maxpark=1
            &maxaddon=1
            &bwlimit=" . $bwlimit . "
            &language=" . $language . "
            &useregns=" . $useregns . "
            &hasuseregns=" . $hasuseregns . "
            &reseller=" . $reseller . "
            &mxcheck=local
            &max_email_per_hour=500
            &max_defer_fail_percentage=80
            ";
        }
        $url = trim(str_replace("\r\n", '', $url));//去除换行
        $url = trim(str_replace(" ", '', $url));//去除空格=
        try {
            $client   = new Client();
            $response = $client->request(
                'GET', $url, [
                         'headers' => ['Authorization' => 'whm ' . $owner . ':' . $server->token]
                     ]
            );
        }
        catch (\Exception $e) {
            Log::error('Cpanel creater host error', [$e, $url]);
            return false;
        }
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        if ($data->metadata->result) {
            $host = HostModel::create(
                [
                    'order_id'   => $order->id,
                    'user_id'    => $order->user_id,
                    'host_name'  => $username,
                    'host_pass'  => $password,
                    'host_panel' => 'Cpanel',
                    'host_url'   => null
                ]
            );
            return $host;
        }
        Log::error('Cpanel error', [$data]);
        return false;

    }

    public function managePanelLogin($server, $host)
    {
        $url    = $server->ip . ":" . $server->port;
        $client = new Client();
        $domain = str_replace(['https://', 'http://'], '', $server->ip);
        $url    .= "/json-api/create_user_session?api.version=1&user=" . $host->host_name . "&service=cpaneld&preferred_domain=" . $domain;
        try {
            $response = $client->request(
                'GET', $url, [
                         'headers' => ['Authorization' => 'whm ' . $server->username . ':' . $server->token]
                     ]
            );
        }
        catch (\Exception $e) {
            Log::error('Cpanel creater host error', [$e, $url]);
            return false;
        }
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        if ($data->metadata->result) {
            return $data->data->url;
        }
        Log::error('Cpanel error', [$data]);
        return false;
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
        $url    = $server->ip . ":" . $server->port;
        $client = new Client();
        $url    .= "/json-api/unsuspendacct?api.version=1&user=" . $host->host_name;
        try {
            $response = $client->request(
                'GET', $url, [
                         'headers' => ['Authorization' => 'whm ' . $server->username . ':' . $server->token]
                     ]
            );
        }
        catch (\Exception $e) {
            Log::error('Cpanel creater host error', [$e, $url]);
            return false;
        }
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        if ($data->metadata->result) {
            return $host;
        }
        Log::error('Cpanel error', [$data]);
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
        $url    = $server->ip . ":" . $server->port;
        $client = new Client();
        $url    .= "/json-api/suspendacct?api.version=1&user=" . $host->host_name;
        try {
            $response = $client->request(
                'GET', $url, [
                         'headers' => ['Authorization' => 'whm ' . $server->username . ':' . $server->token]
                     ]
            );
        }
        catch (\Exception $e) {
            Log::error('Cpanel creater host error', [$e, $url]);
            return false;
        }
        $data = $response->getBody()->getContents();
        $data = json_decode($data);
        if ($data->metadata->result) {
            return $host;
        }
        Log::error('Cpanel error', [$data]);
        return false;
    }
}

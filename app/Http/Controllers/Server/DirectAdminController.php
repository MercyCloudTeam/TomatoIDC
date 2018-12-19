<?php

namespace App\Http\Controllers\Server;

use App\HostModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DirectAdminController extends Controller
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

    public function getIp($server)
    {

        $this->connect($server->ip, 2222);
        $this->set_login($server->username, $server->password);
        $this->query('/CMD_API_SHOW_RESELLER_IPS');
        return $this->fetch_parsed_body();
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
        $userName = strtolower('t' . str_random(7));
        $password = str_random();
        $port     = $server->port ?? $port = 2222;
        $this->connect($server->ip, $port);
        $this->set_login($server->username, $server->password);

        !$configure->email_notice ? $email_notice = 'no' : $email_notice = $configure->email_notice;
        !$order->domain ? $domain = $userName . time() . ".com" : $domain = $order->domain;

        if (empty($configure->customip)) { //指定ip
            $ipList = $this->getIp($server);
            $ip     = array_first($ipList['list']);
        } else {
            $ip = $configure->customip;
        }
        $arr = [
            'action'   => 'create',
            'add'      => 'Submit',
            'username' => $userName,
            'email'    => $order->user->email,
            'passwd'   => $password,
            'passwd2'  => $password,
            'notify'   => $email_notice,
            'domain'   => $domain,
            'ip'       => $ip
        ];

        if (!empty($configure->config_template)) {
            $arr['package'] = $configure->config_template;
            $this->query('/CMD_API_ACCOUNT_USER', $arr);
            $result = $this->fetch_parsed_body();
        } else {
            //and ($arr['ubandwidth'] = "OFF")
            !$configure->flow_limit ? $arr['ubandwidth'] = "ON" : $arr['bandwidth'] = $configure->flow_limit;
            //and ($arr['uquota'] = "OFF");
            !$configure->web_quota ? $arr['uquota'] = "NO" : $arr['quota'] = (int)$configure->web_quota;

            !$configure->maxftp ? $arr['uftp'] = "ON" : $arr['ftp'] = $configure->maxftp;
            //) and ($arr['uftp'] = "OFF")
            !$configure->maxsql ? $arr['mysql'] = "ON" : $arr['mysql'] = $configure->maxsql;
            //) and ($arr['umysql'] = "OFF")
            !$configure->max_subdir ? $arr['unsubdomains'] = "ON" : $arr['nsubdomains'] = $configure->max_subdir;
            //) and ($arr['unsubdomains'] = "OFF")
            !$configure->domain ? $arr['uvdomains'] = "ON" : $arr['vdomains'] = $configure->domain;
            //) and ($arr['uvdomains'] = "OFF")

            !$configure->cgi ? $arr['cgi'] = "ON" : $arr['cgi'] = "ON";
            //配置列表无法设置的选项

            $arr['udomainptr'] = "ON";
            $arr['unemailml']  = "OFF";
            $arr['unemails']   = "OFF";
            $arr['unemailf']   = "OFF";
            $arr['aftp']       = "OFF";

            $arr['spam']       = "ON";
            $arr['cron']       = "ON";
            $arr['catchall']   = "ON";
            $arr['ssl']        = "ON";
            $arr['ssh']        = "OFF";
            $arr['sysinfo']    = "ON";
            $arr['dnscontrol'] = "ON";
            $arr['php']        = "ON";

            //                        dd($arr);
            $this->query('/CMD_API_ACCOUNT_USER', $arr);
            $result = $this->fetch_parsed_body();
        }

        if ($result['error'] == 0) {
            $host = HostModel::create(
                [
                    'order_id'   => $order->id,
                    'user_id'    => $order->user_id,
                    'host_name'  => $userName,
                    'host_pass'  => $password,
                    'host_panel' => 'DirectAdmin',
                    'host_url'   => 'http://'.$server->ip.':'.$port
                ]
            );
            return $host;
        }
        Log::error('DirectAdmin error', [$result]);
        return false;
    }

    //TODO 获取主机信息
    public function getVh($server, $host)
    {

    }

    public function managePanelLogin($server, $host)
    {
//        print_r($this->closeHost($server, $host));
        return false;
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
     * 黑人问号？？？ 文档说请求CMD_API_SELECT_USERS但是请求那个会失败，demo给的是请求现在的
     * 敲
     * 开通主机
     * @param $server
     * @param $host
     * @return bool
     */
    public function openHost($server, $host)
    {
        $port = $server->port ?? $port = 2222;
        $this->connect($server->ip, $port);
        $this->set_login($server->username, $server->password);
        $arr2 = [
            'location' => 'CMD_SELECT_USERS',
            'suspend'  => 'unsuspend',
            'select0'  => $host->host_name
        ];

        $this->query('/CMD_SELECT_USERS', $arr2);
        $result = $this->fetch_body();
        if (!empty($result)) {
            return $host;
        }
        Log::error('DirectAdmin error', [$result]);
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
        $port = $server->port ?? $port = 2222;
        $this->connect($server->ip, $port);
        $this->set_login($server->username, $server->password);
        $arr2 = [
            'location' => 'CMD_SELECT_USERS',
            'suspend'  => 'suspend',
            'select0'  => $host->host_name
        ];

        $this->query('/CMD_SELECT_USERS', $arr2);
        $result = $this->fetch_body();
        if (!empty($result)) {
            return $host;
        }
        Log::error('DirectAdmin error', [$result]);
        return false;
    }

    /**
     * DA面板的Class可忽略
     *
     * Socket communication class.
     *
     * Originally designed for use with DirectAdmin's API, this class will fill any HTTP socket need.
     *
     * Very, very basic usage:
     *   $Socket = new HTTPSocket;
     *   echo $Socket->get('http://user:pass@somesite.com/somedir/some.file?query=string&this=that');
     *
     * @author Phi1 'l0rdphi1' Stier <l0rdphi1@liquenox.net>
     * @package HTTPSocket
     * @version 2.7.2
     * 2.7.2
     * added x-use-https header check
     * added max number of location redirects
     * added custom settable message if x-use-https is found, so users can be told where to set their scripts
     * if a redirect host is https, add ssl:// to remote_host
     * 2.7.1
     * added isset to headers['location'], line 306
     */

    protected $version = '2.7.2';

    /* all vars are private except $error, $query_cache, and $doFollowLocationHeader */

    protected $method = 'GET';

    protected $remote_host;
    protected $remote_port;
    protected $remote_uname;
    protected $remote_passwd;

    protected $result;
    protected $result_header;
    protected $result_body;
    protected $result_status_code;

    protected $lastTransferSpeed;

    protected $bind_host;

    protected $error       = array();
    protected $warn        = array();
    protected $query_cache = array();

    protected $doFollowLocationHeader = TRUE;
    protected $redirectURL;
    protected $max_redirects          = 5;
    protected $ssl_setting_message    = 'DirectAdmin appears to be using SSL. Change your script to connect to ssl://';

    protected $extra_headers = array();

    /**
     * Create server "connection".
     *
     */
    protected function connect($host, $port = '')
    {
        if (!is_numeric($port)) {
            $port = 80;
        }

        $this->remote_host = $host;
        $this->remote_port = $port;
    }

    protected function bind($ip = '')
    {
        if ($ip == '') {
            $ip = $_SERVER['SERVER_ADDR'];
        }

        $this->bind_host = $ip;
    }

    /**
     * Change the method being used to communicate.
     *
     * @param string|null request method. supports GET, POST, and HEAD. default is GET
     */
    protected function set_method($method = 'GET')
    {
        $this->method = strtoupper($method);
    }

    /**
     * Specify a username and password.
     *
     * @param string|null username. defualt is null
     * @param string|null password. defualt is null
     */
    protected function set_login($uname = '', $passwd = '')
    {
        if (strlen($uname) > 0) {
            $this->remote_uname = $uname;
        }

        if (strlen($passwd) > 0) {
            $this->remote_passwd = $passwd;
        }

    }

    /**
     * Query the server
     *
     * @param string containing properly formatted server API. See DA API docs and examples. Http:// URLs O.K. too.
     * @param string|array query to pass to url
     * @param int if connection KB/s drops below value here, will drop connection
     */
    protected function query($request, $content = '', $doSpeedCheck = 0)
    {
        $this->error              = $this->warn = array();
        $this->result_status_code = NULL;

        // is our request a http:// ... ?
        //        dd($this->remote_uname,$this->remote_passwd);
        //        dd(preg_match('!^https://!i', $request),preg_match('!^http://!i', $request));
        if (preg_match('!^http://!i', $request) || preg_match('!^https://!i', $request)) {
            $location = parse_url($request);
            if (preg_match('!^https://!i', $request)) {
                $this->connect('ssl://' . $location['host'], $location['port']);
            } else {
                $this->connect($location['host'], $location['port']);
            }
            if (isset($location['user']) && isset($location['pass'])) {//这里和原本class逻辑有更改，判断有没有user/pass
                $this->set_login($location['user'], $location['pass']);
            }
            $request = $location['path'];
            if (isset($location['query'])) {
                $content = $location['query'];
            }


            if (strlen($request) < 1) {
                $request = '/';
            }
        }
        $array_headers = array(
            'User-Agent' => "HTTPSocket/$this->version",
            'Host'       => ($this->remote_port == 80 ? $this->remote_host : "$this->remote_host:$this->remote_port"),
            'Accept'     => '*/*',
            'Connection' => 'Close'
        );

        foreach ($this->extra_headers as $key => $value) {
            $array_headers[$key] = $value;
        }

        $this->result = $this->result_header = $this->result_body = '';

        // was content sent as an array? if so, turn it into a string
        if (is_array($content)) {
            $pairs = array();

            foreach ($content as $key => $value) {
                $pairs[] = "$key=" . urlencode($value);
            }

            $content = join('&', $pairs);
            unset($pairs);
        }

        $OK = TRUE;

        // instance connection
        if ($this->bind_host) {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_bind($socket, $this->bind_host);

            if (!@socket_connect($socket, $this->remote_host, $this->remote_port)) {
                $OK = FALSE;
            }

        } else {
            $socket = @fsockopen($this->remote_host, $this->remote_port, $sock_errno, $sock_errstr, 10);
        }

        if (!$socket || !$OK) {
            $this->error[] = "Can't create socket connection to $this->remote_host:$this->remote_port.";
            return 0;
        }

        // if we have a username and password, add the header
        if (isset($this->remote_uname) && isset($this->remote_passwd)) {
            $array_headers['Authorization'] = 'Basic ' . base64_encode("$this->remote_uname:$this->remote_passwd");
        }

        // for DA skins: if $this->remote_passwd is NULL, try to use the login key system
        if (isset($this->remote_uname) && $this->remote_passwd == NULL) {
            $array_headers['Cookie'] = "session={$_SERVER['SESSION_ID']}; key={$_SERVER['SESSION_KEY']}";
        }

        // if method is POST, add content length & type headers
        if ($this->method == 'POST') {
            $array_headers['Content-type']   = 'application/x-www-form-urlencoded';
            $array_headers['Content-length'] = strlen($content);
        } // else method is GET or HEAD. we don't support anything else right now.
        else {
            if ($content) {
                $request .= "?$content";
            }
        }

        // prepare query
        $query = "$this->method $request HTTP/1.0\r\n";
        foreach ($array_headers as $key => $value) {
            $query .= "$key: $value\r\n";
        }
        $query .= "\r\n";

        // if POST we need to append our content
        if ($this->method == 'POST' && $content) {
            $query .= "$content\r\n\r\n";
        }

        // query connection
        if ($this->bind_host) {
            socket_write($socket, $query);

            // now load results
            while ($out = socket_read($socket, 2048)) {
                $this->result .= $out;
            }
        } else {
            fwrite($socket, $query, strlen($query));

            // now load results
            $this->lastTransferSpeed = 0;
            $status                  = socket_get_status($socket);
            $startTime               = time();
            $length                  = 0;
            $prevSecond              = 0;
            while (!feof($socket) && !$status['timed_out']) {
                $chunk        = fgets($socket, 1024);
                $length       += strlen($chunk);
                $this->result .= $chunk;

                $elapsedTime = time() - $startTime;

                if ($elapsedTime > 0) {
                    $this->lastTransferSpeed = ($length / 1024) / $elapsedTime;
                }

                if ($doSpeedCheck > 0 && $elapsedTime > 5 && $this->lastTransferSpeed < $doSpeedCheck) {
                    $this->warn[]             = "kB/s for last 5 seconds is below 50 kB/s (~" . (($length / 1024) / $elapsedTime) . "), dropping connection...";
                    $this->result_status_code = 503;
                    break;
                }

            }

            if ($this->lastTransferSpeed == 0) {
                $this->lastTransferSpeed = $length / 1024;
            }

        }

        list($this->result_header, $this->result_body) = preg_split("/\r\n\r\n/", $this->result, 2);

        if ($this->bind_host) {
            socket_close($socket);
        } else {
            fclose($socket);
        }

        $this->query_cache[] = $query;


        $headers = $this->fetch_header();

        // what return status did we get?
        if (!$this->result_status_code) {
            preg_match("#HTTP/1\.. (\d+)#", $headers[0], $matches);
            $this->result_status_code = $matches[1];
        }

        // did we get the full file?
        if (!empty($headers['content-length']) && $headers['content-length'] != strlen($this->result_body)) {
            $this->result_status_code = 206;
        }

        // now, if we're being passed a location header, should we follow it?
        if ($this->doFollowLocationHeader) {
            //dont bother if we didn't even setup the script correctly
            if (isset($headers['x-use-https']) && $headers['x-use-https'] == 'yes')
                die($this->ssl_setting_message);

            if (isset($headers['location'])) {
                if ($this->max_redirects <= 0)
                    die("Too many redirects on: " . $headers['location']);

                $this->max_redirects--;
                $this->redirectURL = $headers['location'];
                $this->query($headers['location']);
            }
        }

    }

    protected function getTransferSpeed()
    {
        return $this->lastTransferSpeed;
    }

    /**
     * The quick way to get a URL's content :)
     *
     * @param string URL
     * @param boolean return as array? (like PHP's file() command)
     * @return string result body
     */
    protected function get($location, $asArray = FALSE)
    {
        $this->query($location);

        if ($this->get_status_code() == 200) {
            if ($asArray) {
                return preg_split("/\n/", $this->fetch_body());
            }

            return $this->fetch_body();
        }

        return FALSE;
    }

    /**
     * Returns the last status code.
     * 200 = OK;
     * 403 = FORBIDDEN;
     * etc.
     *
     * @return int status code
     */
    protected function get_status_code()
    {
        return $this->result_status_code;
    }

    /**
     * Adds a header, sent with the next query.
     *
     * @param string header name
     * @param string header value
     */
    protected function add_header($key, $value)
    {
        $this->extra_headers[$key] = $value;
    }

    /**
     * Clears any extra headers.
     *
     */
    protected function clear_headers()
    {
        $this->extra_headers = array();
    }

    /**
     * Return the result of a query.
     *
     * @return string result
     */
    protected function fetch_result()
    {
        return $this->result;
    }

    /**
     * Return the header of result (stuff before body).
     *
     * @param string (optional) header to return
     * @return array result header
     */
    protected function fetch_header($header = '')
    {
        $array_headers = preg_split("/\r\n/", $this->result_header);

        $array_return = array(0 => $array_headers[0]);
        unset($array_headers[0]);

        foreach ($array_headers as $pair) {
            list($key, $value) = preg_split("/: /", $pair, 2);
            $array_return[strtolower($key)] = $value;
        }

        if ($header != '') {
            return $array_return[strtolower($header)];
        }

        return $array_return;
    }

    /**
     * Return the body of result (stuff after header).
     *
     * @return string result body
     */
    protected function fetch_body()
    {
        return $this->result_body;
    }

    /**
     * Return parsed body in array format.
     *
     * @return array result parsed
     */
    protected function fetch_parsed_body()
    {
        parse_str($this->result_body, $x);
        return $x;
    }


    /**
     * Set a specifc message on how to change the SSL setting, in the event that it's not set correctly.
     */
    protected function set_ssl_setting_message($str)
    {
        $this->ssl_setting_message = $str;
    }
}

?>

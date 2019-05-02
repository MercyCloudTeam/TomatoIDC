<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class AlipayController extends Controller
{
    public $pluginName = "支付宝官方";
    public $pluginType = 'alipay';

    //获取数据库设置
    protected function getSetting()
    {
        foreach ($this->settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
        $result = [];
        foreach ($this->settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;
    }
	protected $settingArray = [
        'setting.website.payment.alipay.app.id' => null,
        'setting.website.payment.alipay.public.key' => null,
        'setting.website.payment.alipay.private.key' => null,
    ];
	protected function setConfig()
    {
        $setting = $this->getSetting();
        $config = $this->config;
        $config['app_id'] = $setting['setting.website.payment.alipay.app.id'];
        $config['ali_public_key'] = $setting['setting.website.payment.alipay.public.key'];
        $config['private_key'] = $setting['setting.website.payment.alipay.private.key'];
        $config['notify_url'] = url('alipay/order/notify');
        $config['return_url'] = url('alipay/order/notify');
        return $config;
    }

    protected $config = [
        'app_id' => null,
        'notify_url' => null,
        'return_url' => null,
        'ali_public_key' => null,
        // 加密方式： **RSA2**
        'private_key' => null,
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        
    ];

	protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
	 public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'utf8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }
public function generateSign($params, $signType = "RSA") {
        return $this->sign($this->getSignContent($params), $signType);
    }
	function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'utf8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
	protected function sign($data, $signType = "RSA") {
		$setting = $this->getSetting();
        $priKey=$setting['setting.website.payment.alipay.private.key'];
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
   
    public function pluginConfigInputForm($payment)
    {
        $this->getSetting();//防止插件未初始化
        if ($payment !== 'alipay') {//防止有人在微信使用支付宝插件
            return null;
        }
        return [
            'AppId' => 'setting.website.payment.alipay.app.id',
            'PublicKey' => 'setting.website.payment.alipay.public.key',
            'PrivateKey' => 'setting.website.payment.alipay.private.key',
        ];
    }

   
public function curlPost($url = '', $postData = '', $options = array())
    {
        if (is_array($postData)) {
            $postData = http_build_query($postData);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
        if (!empty($options)) {
            curl_setopt_array($ch, $options);
        }
        //https请求 不验证证书和host
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    //生成支付URL
    public function Pay($order, $payment)
    {

        
        if ($order->status == 2) { //防止多次支付
            return ['type' => 'qrcode_string', 'url' => "Orders paid"];
        }
$requestConfigs = array(
            'out_trade_no'=>$order->no,
            'total_amount'=>$order->price, //单位 元
            'subject'=>$order->no . '|订单支付',  //订单标题
            'timeout_express'=>'5m'       //该笔订单允许的最晚付款时间，逾期将关闭交易。取值范围：1m～15d。m-分钟，h-小时，d-天，1c-当天（1c-当天的情况下，无论交易何时创建，都在0点关闭）。 该参数数值不接受小数点， 如 1.5h，可转换为 90m。
        );
		$setting = $this->getSetting();
		$apidsa=$setting['setting.website.payment.alipay.app.id'];
        $commonConfigs = array(
            //公共参数
            'app_id' => $apidsa,
            'method' => 'alipay.trade.precreate',             //接口名称
            'format' => 'JSON',
            'charset'=> 'utf8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url' => url('alipay/order/notify'),
            'biz_content'=>json_encode($requestConfigs),
        );
		 
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost('https://openapi.alipay.com/gateway.do',$commonConfigs);
         $paysssh=json_decode($result,true);
		$su=$paysssh['alipay_trade_precreate_response']['msg'];
		
		if($su!=='Success'){
			$subfa_msg=$paysssh['alipay_trade_precreate_response']['sub_msg'];
			return ['type' => 'qrcode_string', 'url' => $subfa_msg];//错误返回
			
		}else{
        $qr=$paysssh['alipay_trade_precreate_response']['qr_code'];
        return ['type' => 'qrcode_string', 'url' => $qr];//暂时
		}
//        return Pay::alipay()->web($order);
    }

    public function notify($request, $payment)
    {
        $alipay = Pay::alipay($this->getSetting);

        try {
            $data = $alipay->verify(); // 是的，验签就这么简单！


            Log::debug('Alipay notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }
	public function checkOrderStatus($order)
    {
		$requestConfigs = array(
            'out_trade_no'=>$order->no,
        );
		$setting = $this->getSetting();
		$apidsa=$setting['setting.website.payment.alipay.app.id'];
        $commonConfigs = array(
            //公共参数
            'app_id' => $apidsa,
            'method' => 'alipay.trade.query',             //接口名称
            'format' => 'JSON',
            'charset'=> 'utf8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'notify_url' => url('alipay/order/notify'),
            'biz_content'=>json_encode($requestConfigs),
        );
		 
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        $result = $this->curlPost('https://openapi.alipay.com/gateway.do',$commonConfigs);
         $payssshsafa=json_decode($result,true);
		$sudas=$payssshsafa['alipay_trade_query_response']['trade_status'];
		$sudafaga=$payssshsafa['alipay_trade_query_response']['out_trade_no'];
        if ($sudas!=='Success') {
            return false;
        }
        if ($sudas == "TRADE_SUCCESS" && $$sudafaga == $order->no) {
            return true;
        }
        return false;
    }
}

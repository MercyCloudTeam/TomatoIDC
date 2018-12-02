<?php

namespace App\Http\Controllers\Payment;

/**
 * 针对番茄云支付编写
 */

use App\Http\Controllers\Controller;
use App\OrderModel;
use App\SettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FanQieController extends Controller
{
    public $pluginName = "番茄云支付";
    public $pluginType=true;
    //签名
    protected function makeSign($mchid, $account, $cny, $orderid, $key)
    {
        return md5("mchid=" . $mchid . "&account=" . $account . "&cny=" . $cny . "&type=1&trade=" . $orderid . $key);
    }

    //接口地址
    protected $wechatUrl = "https://b.fanqieui.com/gateways/wxpay.php";
    protected $alipayUrl = "https://b.fanqieui.com/gateways/submit.php";

    //配置名称
    protected $settingArray = [
        'setting.website.payment.fanqie.wechat.key' => null,
        'setting.website.payment.fanqie.wechat.account' => null,
        'setting.website.payment.fanqie.wechat.mchid' => null,
        'setting.website.payment.fanqie.alipay.mchid' => null,
        'setting.website.payment.fanqie.alipay.account' => null,
        'setting.website.payment.fanqie.alipay.key' => null,
    ];

    public function pluginConfigInputForm($payment)
    {
//        dd($payment);
        $this->getSetting();//防止插件未初始化
        switch ($payment) {
            case 'wechat':
                return [
                    '商户密匙' => 'setting.website.payment.fanqie.wechat.key',
                    '商户账户' => 'setting.website.payment.fanqie.wechat.account',
                    '商户ID' => 'setting.website.payment.fanqie.wechat.mchid'
                ];
                break;
            case 'alipay':
                return [
                    '商户密匙' => 'setting.website.payment.fanqie.alipay.key',
                    '商户账户' => 'setting.website.payment.fanqie.alipay.account',
                    '商户ID' => 'setting.website.payment.fanqie.alipay.mchid'
                ];
                break;
            default :
                return false;
        }
    }

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

    //TODO 白名单验证
    //回调验证更新订单
    //番茄坑我，md文档和实际返回不一样 花Q
    //微信支付可能存在安全问题
    //如果有思路的大佬看到这里就知道怎么利用了（逃）
    /**
     * 回调验证
     * @param $request
     * @param $payment
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function notify($request, $payment)
    {
        $this->validate($request, [ //验证
            'trade_status' => "string|nullable",
            'trade_no' => "string|required",
            'out_trade_no' => "string|required",
            'sign' => "string|nullable",
            'key' => "string|nullable",
            'total_fee' => "string|nullable",
            'money' => "string|nullable",
        ]);
        $setting = $this->getSetting();
        $key = $setting['setting.website.payment.fanqie.' . $payment . ".key"];

        $security = array();
        $security['out_trade_no'] = $request['out_trade_no'];
        $security['total_fee'] = $request['total_fee'];
        $security['trade_no'] = $request['trade_no'];
        $security['trade_status'] = $request['trade_status'];
//        empty($request['trade_status']) ? null : $security['trade_status'];
        $o = "";
        foreach ($security as $k => $v) {
            $o .= "$k=" . $v . "&";
        }
        $sign = md5(substr($o, 0, -1) . $key);

        switch ($payment) {
            case 'wechat':
                $getSign = $request['key'];
                if ($key == $getSign) {//验签
                    return $request['out_trade_no'];
                } else {
                    Log::info('FanQiePay Error', ['trade_no' => $request['trade_no']]);
                }
                break;
            case 'alipay':
                $getSign = $request['sign'];
                if ($sign == $getSign) {//验签
                    return $request['out_trade_no'];
                } else {
                    Log::info('FanQiePay Error', ['trade_no' => $request['trade_no']]);
                }
                break;
            default :
                return false;
        }
        return false;
    }

    public function curlPost($url, $post)
    {
        $ch = curl_init();  //初始化一个cURL会话
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); //设置超时
        if (0 === strpos(strtolower($url), 'https')) {
            //https请求
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); //从证书中检查SSL加密算法是否存在
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //生成支付URL
    public function Pay($order, $payment)
    {
        $setting = $this->getSetting();
        $mchid = $setting['setting.website.payment.fanqie.' . $payment . ".mchid"];
        $account = $setting['setting.website.payment.fanqie.' . $payment . ".account"];
        $key = $setting['setting.website.payment.fanqie.' . $payment . ".key"];
        $price = sprintf("%01.2f", $order->price);
        $on = $order->no;

        if ($order->status == 2) { //防止多次支付
            return ['type' => 'qrcode_string', 'url' => "Orders paid"];
        }

        $sign = $this->makeSign($mchid, $account, $price, $on, $key);
        $data = [
            'account' => $account,
            'mchid' => $mchid,
            'type' => '1',
            'trade' => $on,
            'cny' => $price,
            'signs' => $sign
        ];
//        dd($data);
        $url = $payment . 'Url';//设置URL
        $result = $this->curlPost($this->$url, $data);
        if (empty($result)) {
            Log::info('Make Pay Url Error', ['url' => $this->$url, 'date' => $data]);
            return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
        }
        switch ($payment) {
            case "wechat":
                preg_match('/weixin.*</', $result, $weixin);
                $weixin = str_replace('<', '', $weixin[0]);
                return ['type' => 'qrcode_string', 'url' => $weixin];
            case "alipay":
                preg_match('/https:\/\/mapi.*MD5/', $result, $alipay);
                return ['type' => 'redirect', 'url' => $alipay[0]];
        }
        return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
    }

    /**
     * 番茄云支付不支持订单查询
     * @return bool
     */
    public function checkOrderStatus()
    {
        return false;
    }


}

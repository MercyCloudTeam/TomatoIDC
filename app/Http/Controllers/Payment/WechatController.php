<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class WechatController extends Controller
{
    public $pluginName = "微信官方";
    public $pluginType='wechat';

    protected $config = [
        'appid' => null, // APP APPID
        'app_id' => null, // 公众号 APPID
        'miniapp_id' => null, // 小程序 APPID
        'mch_id' => null,
        'key' => null,
        'notify_url' => null,
        'cert_client' => null, // optional，退款等情况时用到
        'cert_key' => null,// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
//        'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ];

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

    //配置名称
    protected $settingArray = [
        'setting.website.payment.wechat.app.id' => null,
        'setting.website.payment.wechat.miniapp.id' => null,
        'setting.website.payment.wechat.appid' => null,
        'setting.website.payment.wechat.mch.id' => null,
        'setting.website.payment.wechat.key' => null,
    ];

    /**
     * 插件设置页面
     * @param $payment
     * @return array
     */
    public function pluginConfigInputForm($payment)
    {
        $this->getSetting();//防止插件未初始化
        if ($payment !== 'wechat'){//防止有人在支付宝使用微信插件
            return null;
        }
        return [
            '公众号APP_ID' =>'setting.website.payment.wechat.app.id', //公众号 APPID
            '小程序APP_ID' =>'setting.website.payment.wechat.miniapp.id',
            'APP_APPID' =>'setting.website.payment.wechat.appid', //APP APPID
            'MCH_ID' =>'setting.website.payment.wechat.mch.id',
            'KEY' =>'setting.website.payment.wechat.key',
        ];
    }

    /**
     * 回调
     * @param $request
     * @param $payment
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     */
    public function notify($request, $payment)
    {
        $pay = Pay::wechat($this->setConfig());

        try{
            $data = $pay->verify(); // 是的，验签就这么简单！
            if ($data->trade_state == "SUCCESS"){
                return $data->out_trade_no;
            }
            Log::debug('Wechat notify', $data->all());
        } catch (\Exception $e) {
        }
        $pay->success();


    }

    /**
     * 获取设置
     * @return array
     */
    protected function setConfig()
    {
        $setting = $this->getSetting();
        $config = $this->config;
        $config['appid']=$setting['setting.website.payment.wechat.appid'];
        $config['app_id']=$setting['setting.website.payment.wechat.app.id'];
        $config['miniapp_id']=$setting['setting.website.payment.wechat.miniapp.id'];
        $config['mch_id']=$setting['setting.website.payment.wechat.mch.id'];
        $config['key']=$setting['setting.website.payment.wechat.key'];
        $config['notify_url']=url('wechat/order/notify');
        return $config;
    }

    /**
     * 生成支付URL
     * @param $order
     * @param $payment
     * @return array
     */
    public function Pay($order, $payment)
    {
        $configOrder = [
            'out_trade_no' => $order->no,
            'body' =>$order->no.'|订单支付',
            'total_fee' => $order->price*100, // **单位：分** 说不出话
        ];
        if ($order->status == 2) { //防止多次支付
            return ['type' => 'qrcode_string', 'url' => "Orders paid"];
        }

        try {
            $result = Pay::wechat($this->setConfig())->scan($configOrder);
        } catch (\Exception $e){
            return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
        }
        $qr = $result->code_url;
        return ['type' => 'qrcode_string', 'url' => $qr];
    }

    /**
     * 订单查询
     * @return bool
     */
    public function checkOrderStatus($order)
    {
        $result = Pay::wechat($this->setConfig())->find($order->no);
        if (empty($result)){
            return false;
        }
        if ($result->trade_state == "SUCCESS" && $result->out_trade_no == $order->no ){
            return true;
        }
        return false;
    }
}

<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log;

class AlipayController extends Controller
{
    public $pluginName = "支付宝官方-未测试";
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

    //配置名称
    protected $settingArray = [
        'setting.website.payment.alipay.app.id' => null,
        'setting.website.payment.alipay.public.key' => null,
        'setting.website.payment.alipay.private.key' => null,
    ];

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
        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ];


    public function notify($request, $payment)
    {
        $alipay = Pay::alipay($this->getSetting());

        try {
            $data = $alipay->verify(); // 是的，验签就这么简单！


            Log::debug('Alipay notify', $data->all());
        } catch (Exception $e) {
            // $e->getMessage();
        }

        return $alipay->success()->send();// laravel 框架中请直接 `return $alipay->success()`
    }

    //生成支付URL
    public function Pay($order, $payment)
    {

        $configOrder = [
            'out_trade_no' => $order->no,
            'subject' => $order->no . '|订单支付',
            'total_amount' => sprintf("%01.2f", $order->price),
        ];
        if ($order->status == 2) { //防止多次支付
            return ['type' => 'qrcode_string', 'url' => "Orders paid"];
        }

        try {
            $result = Pay::alipay($this->setConfig())->scan($configOrder);
        } catch (\Exception $e) {
            return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
        }
        $qr = $result->qr_code;
        return ['type' => 'qrcode_base64', 'url' => $qr];//暂时

//        return Pay::alipay()->web($order);
    }

    public function checkOrderStatus($order)
    {
        $result = Pay::alipay($this->setConfig())->find($order->no);
        if (empty($result)) {
            return false;
        }
        if ($result->trade_state == "SUCCESS" && $result->out_trade_no == $order->no) {
            return true;
        }
        return false;
    }
}

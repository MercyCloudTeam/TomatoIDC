<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;

class CodePayController extends Controller
{
    public $pluginName = "码支付-未完成";
    public $pluginType = true;
    //配置名称
    protected $settingArray =
        [
            'setting.website.payment.code.pay.id' => null,
            'setting.website.payment.code.pay.key' => null,
//            'setting.website.payment.code.pay.token' => null,
        ];

    /**
     * 插件设置页面
     * @param $payment
     * @return array
     */
    public function pluginConfigInputForm($payment)
    {
        return null;
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
        return $request->no;
    }


    /**
     * 生成支付URL
     * @param $order
     * @param $payment
     * @return array
     */
    public function Pay($order, $payment)
    {
        switch ($payment){
            case "wechat":
                break;
            case "alipay":
                break;
            case "qqpay":
                break;
        }

    }

    /**
     * 订单查询
     * @return bool
     */
    public function checkOrderStatus($order)
    {
        return true;
    }
}

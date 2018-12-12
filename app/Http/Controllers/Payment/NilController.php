<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;

class NilController extends Controller
{
    public $pluginName = "白嫖支付-任何订单不用付款";
    public $pluginType = true;
    //配置名称
    protected $settingArray
        = [

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
        return ['type' => 'redirect', 'url' => route('order.show')];
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

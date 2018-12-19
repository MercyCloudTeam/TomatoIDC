<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;
use GuzzleHttp\Client;
use Yansongda\Pay\Log;

class CodePayController extends Controller
{
    public $pluginName = "码支付-未完成";
    public $pluginType = true;

    protected $url = "https://codepay.fateqq.com/creat_order";
    //配置名称
    protected $settingArray
        = [
            'setting.website.payment.code.pay.id'    => null,
            'setting.website.payment.code.pay.token' => null,
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

    //获取数据库设置
    protected function getSetting()
    {
        foreach ($this->settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create(
                    [
                        'name'  => $key,
                        'value' => $value
                    ]
                );
            }
        }
        $result = [];
        foreach ($this->settingArray as $key => $value) {
            $setTemp      = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;
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
        switch ($payment) {
            case "wechat":
                $type = 3;
                break;
            case "alipay":
                $type = 1;
                break;
            case "qqpay":
                $type = 2;
                break;
        }

        if ($order->status == 2) { //防止多次支付
            return ['type' => 'qrcode_string', 'url' => "Orders paid"];
        }
        $setting = $this->getSetting();
        $price   = sprintf("%01.2f", $order->price);
        $on      = $order->no;
        $id      = $setting['setting.website.payment.code.pay.id'];
        $url     = $this->url . '?id=' . $id . '&type=' . $type . "&price=" . $price;
        try {
            $client   = new Client();
            $response = $client->request('GET', $url);
        }
        catch (\Exception $e) {
            Log::error('codepay error', [$e]);
            return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];
        }
        $result = $response->getBody()->getContents();
//        dd($result);
        return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];

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

<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\SettingModel;
use GuzzleHttp\Client;
use Yansongda\Pay\Log;

class CodePayController extends Controller
{
    public $pluginName = "码支付-未测试";
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
        return [
            'ID'   => 'setting.website.payment.code.pay.id',
            '通信密钥' => 'setting.website.payment.code.pay.token'
        ];
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
     */
    public function notify($request, $payment)
    {
        $setting = $this->getSetting();
        ksort($request); //排序post参数
        reset($request); //内部指针指向数组中的第一个元素
        $codepay_key = $setting['setting.website.payment.code.pay.token']; //这是您的密钥
        $sign        = '';//初始化
        foreach ($request AS $key => $val) { //遍历POST参数
            if ($val == '' || $key == 'sign')
                continue; //跳过这些不签名
            if ($sign)
                $sign .= '&'; //第一个字符串签名不加& 其他加&连接起来参数
            $sign .= "$key=$val"; //拼接为url参数形式
        }
        if (!$request['pay_no'] || md5($sign . $codepay_key) != $request['sign']) { //不合法的数据
            exit('fail');  //返回失败 继续补单
        } else { //合法的数据
            //业务处理
            $pay_id = $request['pay_id']; //需要充值的ID 或订单号 或用户名
            return $pay_id;
        }
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

        $data = array(
            "id"         => $setting['setting.website.payment.code.pay.id'],//你的码支付ID
            "pay_id"     => $order->no, //唯一标识 可以是用户ID,用户名,session_id(),订单ID,ip 付款后返回
            "type"       => 1,//1支付宝支付 3微信支付 2QQ钱包
            "price"      => $price,//金额100元
            "param"      => "",//自定义参数
            "notify_url" => action('Payment\PayController@notify', ['payment' => $payment]),//通知地址
            "return_url" => action('Payment\PayController@notify', ['payment' => $payment]),//跳转地址
        ); //构造需要传递的参数

        ksort($data); //重新排序$data数组
        reset($data); //内部指针指向数组中的第一个元素

        $sign = ''; //初始化需要签名的字符为空
        $urls = ''; //初始化URL参数为空

        foreach ($data AS $key => $val) { //遍历需要传递的参数
            if ($val == '' || $key == 'sign')
                continue; //跳过这些不参数签名
            if ($sign != '') { //后面追加&拼接URL
                $sign .= "&";
                $urls .= "&";
            }
            $sign .= "$key=$val"; //拼接为url参数形式
            $urls .= "$key=" . urlencode($val); //拼接为url参数形式并URL编码参数值

        }
        $query = $urls . '&sign=' . md5($sign . $setting['setting.website.payment.code.pay.token']); //创建订单所需的参数
        $url   = "http://api2.fateqq.com:52888/creat_order/?{$query}"; //支付页面
        return ['type' => 'redirect', 'url' => $url];
    }

    /**
     * 订单查询
     * @return bool
     */
    public function checkOrderStatus($order)
    {
        return false;
    }
}

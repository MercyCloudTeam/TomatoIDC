<?php

namespace App\Http\Controllers\Payment;

/**
 * 有赞云支付
 */

use App\Http\Controllers\Controller;
use App\OrderModel;
use App\SettingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Overtrue\LaravelYouzan\Youzan;

class YouZanController extends Controller
{
    public $pluginName = "有赞云支付";
    public $pluginType=true;
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
        'setting.website.payment.youzan.client.id' => null,
        'setting.website.payment.youzan.client.secret' => null,
        'setting.website.payment.youzan.store.id' => null,
    ];

    /**
     * 返回插件设计项
     * @param $payment
     * @return array
     */
    public function pluginConfigInputForm($payment)
    {
        $this->getSetting();//防止插件未初始化
        return [
            'ClientId' => 'setting.website.payment.youzan.client.id',
            'ClientSecret' => 'setting.website.payment.youzan.client.secret',
            'StoreId' => 'setting.website.payment.youzan.store.id'
        ];
    }

    /**
     * 回调
     * @param $request
     * @param $payment
     * @return bool
     */
    public function notify($request, $payment)
    {
        if ($request['type'] == 'TRADE_ORDER_STATE'
            && $request['status'] == 'TRADE_SUCCESS') {
            $result  = Youzan::get('youzan.trade.get', ['tid' => $request->id]);
            $payController =new PayController();
            $order = $payController->getOrder(null,$result->id);
            if ($order) {
                return $order->no;
            }
        }
    }

    /**
     * 设置Key
     */
    protected function setApiConfig()
    {
        $setting = $this->getSetting();
        config(['youzan.apps.default.client_id' => $setting['setting.website.payment.youzan.client.id']]);
        config(['youzan.apps.default.client_secret' => $setting['setting.website.payment.youzan.client.secret']]);
        config(['youzan.apps.default.kdt_id' => $setting['setting.website.payment.youzan.store.id']]);
    }

    //生成支付URL
    public function Pay($order, $payment)
    {
        $this->setApiConfig();
        //如果用户已经创建有赞订单（更新时间小于三十分钟）则查询并返回之前生成的二维码
        if (!empty($order->api_no) && $order->updated_at >= Carbon::now()->subMinutes(30)){
            $result = Youzan::get('youzan.pay.qrcode.get',['qr_id'=>$order->api_no]);
            if (!empty($result)){
                return ['type' => 'qrcode_base64', 'date' => $result['response']['qr_code']];//返回
            }
        }

        $result = Youzan::post('youzan.pay.qrcode.create', [
            'qr_name' => $order->no . '|订单支付',
            'qr_price' => $order->price * 100,
            'qr_type' => 'QR_TYPE_DYNAMIC',
            'qr_source' => $order->no
        ]);
        if (!empty($result)) {
            $order->where('no', $order->no)->update(['api_no' => $result['response']['qr_id']]);//记录订单编号
            return ['type' => 'qrcode_base64', 'date' => $result['response']['qr_code']];//返回
        }
        return ['type' => 'qrcode_string', 'url' => "Error Place Check Setting"];//错误返回
    }

    /**
     * 查询订单
     * @param $order
     * @return bool
     */
    public function checkOrderStatus($order)
    {
        $this->setApiConfig();
        if (empty($order->api_no)){
            return false;
        }
        $result = Youzan::get('youzan.trades.qr.get', [
            'qr_id' => $order->api_no,
            'status' => 'TRADE_RECEIVED'
        ]);
        if (!empty($result)) {
            if ($result['response']['total_results'] > 0) {
                return true;
            }
        }
        return false;
    }
}

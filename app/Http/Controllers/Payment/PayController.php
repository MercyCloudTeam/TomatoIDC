<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserRechargeController;
use App\OrderModel;
use App\ServerModel;
use App\SettingModel;
use App\UserRechargeModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayController extends Controller
{
    /**
     * 获取支付插件
     * @return array
     */
    public static function getPayPluginArr()
    {
        $path = app_path('Http/Controllers/Payment/');
        $fileTemp = scandir($path);
        $fileList = [];
        foreach ($fileTemp as $value) {
            if ($value != '.' && $value != '..' && $value != "PayController.php") {
                $value = str_replace('Controller.php', '', $value);//排除后缀
                $controllerName = __NAMESPACE__ . '\\' . $value . "Controller";
                $plugin = new $controllerName();//动态调用控制器

                if (property_exists($plugin, 'pluginName')) {
                    $plugName = $plugin->pluginName;
                } else {
                    $plugName = $value;
                }
//                dd($plugName);
//                $plugName = $plugin->pluginName;
                array_push($fileList, [$plugName => $value]);
            }
        }
        return $fileList;
    }

    /**
     * 返回支付页面
     * @param $payPage
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function payPage($payPage)
    {
        switch ($payPage['type']) { //判断插件返回值
            case "qrcode_base64":
                return view(ThemeController::backThemePath('pay', 'home'),compact('payPage'));
                break;
            case "qrcode_string": //二维码
                return view(ThemeController::backThemePath('pay', 'home'),compact('payPage'));
                break;
            case "redirect": //跳转
                return redirect($payPage['url']);
                break;
        }
    }

    /**
     * 生成支付
     * @param $payment
     * @param $order
     * @return bool|mixed
     */
    public function makePay($payment,$order){
        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $payment)->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $order->price = $order->money; //解决数据键名不一
            $payPage = $this->orderPay($payPlugin, $payment, $order);
//            dd($payPage);
            return $payPage;
        }
        return false;
    }

    /**
     * 订单支付
     * @param $payPlugin
     * @param $payment
     * @param $order
     * @return mixed
     */
    public function orderPay($payPlugin, $payment, $order)
    {
        $controllerName = __NAMESPACE__ . '\\' . $payPlugin . "Controller";
        $plugin = new $controllerName();//动态调用控制器
        return $plugin->Pay($order, $payment);
    }


    /**
     * 接收支付回调
     * @param Request $request
     * @param string $payment
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function notify(Request $request, string $payment)
    {
//        Log::info('Payment Log', ['request' => $request, 'payment' => $payment]);
        $payment = htmlspecialchars(trim($payment));
        switch ($payment) {
            case "wechat":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.wechat')->first();
                break;
            case "alipay":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.alipay')->first();
                break;
            case 'diy'://如果是多码合一或其他，交给支付宝的插件
                $payPlugin = SettingModel::where('name', 'setting.website.payment.alipay')->first();
                break;
            default:
                Log::info('Notify Error', ['payment' => $payment]);
        }
        $payPlugin = $payPlugin->value;
        $controllerName = __NAMESPACE__ . '\\' . $payPlugin . "Controller";
        $plugin = new $controllerName();//动态调用控制器
        if ($no = $plugin->notify($request, $payment)) {
            return $this->paySuccessAction($no);
        }
        return redirect(route('order.show'));//默认返回
    }

    /**
     * 获取订单，成功返回true 失败返回false
     * @param $no
     * @return bool
     */
    public function getOrder($no,$api_no=null)
    {
        $key = 'no';
        $value = $no;
        if (!empty(htmlspecialchars(trim($api_no)))){ //使用第三方订单号查询
            $key = 'api_no';
            $value = $api_no;
        }
        //订单
        $order = OrderModel::where($key,$value)->get();
        if (!$order->isEmpty()) {//订单支付
            return $order->first();
        }
        //用户充值
        $userRecharge = UserRechargeModel::where($key,$value)->get();
        if (!$userRecharge->isEmpty()) {//充值支付
           return $userRecharge->first();
        }
        return false;
    }

    /**
     * 支付成功操作
     * @param $no string 订单号
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector 视图
     */
    protected function paySuccessAction($no)
    {
        //订单
        $order = OrderModel::where('no',$no)->get();
        if (!$order->isEmpty()) {//订单支付
            if ($order->first()->status == 1) {
                OrderModel::where('no', $no)->update(['status' => 2]);
                $action = new OrderController();
                $action->orderCheckStatusFun($no);
                return redirect(route('order.status', ['no' => $no]));
            }
        }
        //用户充值
        $userRecharge = UserRechargeModel::where('no',$no)->get();
        if (!$userRecharge->isEmpty()) {//充值支付
            if ($userRecharge->first()->status == 1) {//当订单状态还是未支付再进行更改
                UserRechargeModel::where('no', $no)->update(['status' => 3]);
                $action = new UserRechargeController();
                $action->userRechargeCheckStatusFun($no);
                return redirect(route('user.recharge.status', ['no' => $no]));
            }
        }
        return redirect(route('order.show'));//默认返回
    }

    /**
     * 自动查询订单状态
     * @return bool
     */
    public function autoCheckOrderStatus()
    {
        $orders = OrderModel::where([
            ['status',1],
            ['created_at','>=',Carbon::now()->subHour()]
        ])->get();
        if (!$orders->isEmpty()) {
            $alipayPayPlugin = SettingModel::where('name', 'setting.website.payment.alipay')->first()->value;
            $wechatPayPlugin = SettingModel::where('name', 'setting.website.payment.wechat')->first()->value;
            $controllers = [$alipayPayPlugin,$wechatPayPlugin];
            foreach ($controllers as $controller){ //查询
                if (empty($controller)){//未设置的时候跳过
                    continue;
                }
                $controllerName = __NAMESPACE__ . '\\' . $controller . "Controller";
                $plugin = new $controllerName;
                foreach ($orders as $order) {//每笔订单都查询一边
                    $status = $plugin->checkOrderStatus($order);
                    if ($status){//支付成功操作
                        $this->paySuccessAction($order->no);
                    }
                }
            }
        }
        return true;
    }

    /**
     * get payment plugin config from input
     * 获取插件配置表单
     * @param $pluginName string plugin name
     * @param $payment string alipay|wechat|diy|qqpay payemnt
     * @return array|false  success array   failure false
     */
    public function pluginConfigInputForm($pluginName, $payment)
    {
        $controllerName = __NAMESPACE__ . '\\' . $pluginName . "Controller";
        if (class_exists($controllerName)) {
            $plugin = new $controllerName();//动态调用控制器
            if (method_exists($plugin,'pluginConfigInputForm')) {
                return $plugin->pluginConfigInputForm($payment);
            }
        }
        return false;
    }

    /**
     * 获取插件表单
     * @param $payment string alipay|wechat Payment
     * @return bool|mixed
     */
    public function getPayPluginInputForm($payment)
    {
        $payment = htmlspecialchars(trim($payment));
        switch ($payment) {
            case "wechat":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.wechat')->first();
                break;
            case "alipay":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.alipay')->first();
                break;
            case "qqpay":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.qqpay')->first();
                break;
            case "diy":
                $payPlugin = SettingModel::where('name', 'setting.website.payment.diy')->first();
                break;
            default :
                return false;
        }

        if (empty($payPlugin['value'])) {
            return false;
        }
        $form = $this->pluginConfigInputForm($payPlugin['value'], $payment);
        return $form;
    }

    /**
     * Payment Plugin Config Action
     * @param Request $request User push content
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector back page
     * @throws \Illuminate\Validation\ValidationException
     */
    public function paymentPluginConfigAction(Request $request)
    {
        $form = $this->getPayPluginInputForm($request['payment']);
        if (empty($form)) {
            return redirect(route('admin.setting.index'));
        }
        foreach ($form as $key => $value) {
            $this->validate($request, [
                $key => 'string|nullable'
            ]);
            SettingModel::where('name', $value)->update(['value' => $request[$key]]);
        }
        return back()->with('status','success');
    }
}

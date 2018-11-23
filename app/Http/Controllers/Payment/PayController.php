<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\OrderModel;
use App\SettingModel;
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
            default:
                Log::info('Notify Error', ['payment' => $payment]);
        }
        $payPlugin = $payPlugin->value;
        $controllerName = __NAMESPACE__ . '\\' . $payPlugin . "Controller";
        $plugin = new $controllerName();//动态调用控制器
        if ($no = $plugin->notify($request, $payment)) {
            OrderModel::where('no', $no)->update(['status' => 2]);
            return redirect(route('order.status', ['no' => $no]));
        }
        return redirect(route('order.show'));
    }

    /**
     * 获取插件配置表单
     * @param $pluginName
     * @param $payment
     * @return mixed
     */
    public function pluginConfigInputForm($pluginName, $payment)
    {
        $controllerName = __NAMESPACE__ . '\\' . $pluginName . "Controller";
//        dd($pluginName);
        $plugin = new $controllerName();//动态调用控制器
        return $plugin->pluginConfigInputForm($payment);
    }

    /**
     * 判断是否手机
     * @return bool
     */
    public static function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return TRUE;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? TRUE : FALSE;// 找不到为flase,否则为TRUE
        }
        // 判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array(
                'mobile',
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return TRUE;
            }
        }
        if (isset ($_SERVER['HTTP_ACCEPT'])) { // 协议法，因为有可能不准确，放到最后判断
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== FALSE) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === FALSE || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return TRUE;
            }
        }
        return FALSE;
    }

}

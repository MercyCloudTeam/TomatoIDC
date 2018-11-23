<?php

namespace App\Http\Controllers;

use App\GoodModel;
use App\HostModel;
use App\Http\Controllers\Payment\PayController;
use App\OrderModel;
use App\SettingModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 续费主机并生成订单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function renewHostAction(Request $request)
    {
        $this->validate($request, [ //验证
            'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
            'id' => 'exists:hosts,id|required',
            'aff_no' => 'string|nullable',
        ]);

        $host = HostModel::where('id', $request['id'])->first();
        $this->authorize('update', $host);//防止越权
        //创建订单
        $no = date('y') . mt_rand(10, 99) . substr(time(), 6) . mt_rand(100, 999);
        $good = GoodModel::where('id', $host->order->good->id)->first();
        $order = OrderModel::create([
            'good_id' => $good->id,
            'user_id' => Auth::id(),
            'no' => $no,
            'type' => 'renew',
            'aff_no' => $request['no'],
            'price' => $good->price,
        ]);
        OrderModel::where('id', $order->id)->update(['host_id' => $host->id]);

        if (!$good->price) {//白嫖 免费
            OrderModel::where('id', $order->id)->update(['status' => 2]);
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            if ($good->price <= User::where('id', Auth::id())->first()->account) {
                User::where('id', Auth::id())->update(['account' => Auth::user()->account - $good->price]);
                OrderModel::where('id', $order->id)->update(['status' => 2]);
                return redirect(route('order.status', ['no' => $order['no']]));
            }
        }

        //微信支付宝调用插件
        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay = new PayController;
            $payPage = $pay->orderPay($payPlugin, $request['payment'], $order);
            switch ($payPage['type']) { //判断插件返回值
                case "qrcode": //二维码
//                    if (PayController::isMobile()){
//                        return redirect($payPage['url']);
//                        break;
//                    }
                    return view(ThemeController::backThemePath('pay', 'home.goods'), compact('order', 'payPage'));
                    break;
                case "redirect": //跳转
                    return redirect($payPage['url']);
                    break;
            }
        }
        return redirect(route('order.show')); //默认返回
    }

    /**
     * 创建订单并支付
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function orderCreateAction(Request $request)
    {
        $this->validate($request, [ //验证
            'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
            'id' => 'exists:goods,id|required',
            'aff_no' => 'string|nullable',
        ]);

        $no = date('y') . mt_rand(10, 99) . substr(time(), 6) . mt_rand(100, 999);
        $good = GoodModel::where('id', $request['id'])->first();

        $order = OrderModel::create([ //创建订单
            'good_id' => $request['id'],
            'user_id' => Auth::id(),
            'no' => $no,
            'type' => 'new',
            'aff_no' => $request['no'],
            'price' => $good->price,
        ]);

        if (!$good->price) {//白嫖 免费
            OrderModel::where('id', $order->id)->update(['status' => 2]);
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            if ($good->price <= User::where('id', Auth::id())->first()->account) {
                User::where('id', Auth::id())->update(['account' => Auth::user()->account - $good->price]);
                OrderModel::where('id', $order->id)->update(['status' => 2]);
                return redirect(route('order.status', ['no' => $order['no']]));
            }
        }

        //微信支付宝调用插件
        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay = new PayController;
            $payPage = $pay->orderPay($payPlugin, $request['payment'], $order);
            switch ($payPage['type']) { //判断插件返回值
                case "qrcode": //二维码
//                    if (PayController::isMobile()){
//                        return redirect($payPage['url']);
//                        break;
//                    }
                    return view(ThemeController::backThemePath('pay', 'home.goods'), compact('order', 'payPage'));
                    break;
                case "redirect": //跳转
                    return redirect($payPage['url']);
                    break;
            }
        }
        return redirect(route('order.show')); //默认返回
    }

    /**
     * 重新生成支付
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function rePayOrderAction(Request $request)
    {
        $this->validate($request, [
            'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
            'no' => 'exists:orders,no|required',
        ]);
        $order = OrderModel::where('no', $request['no'])->first();

        $this->authorize('view', $order);//防止越权

        if ($order->status != 1) { //验证
            return redirect(route('order.show'));
        }

        if (!$order->price) {//白嫖 免费
            OrderModel::where('id', $order->id)->update(['status' => 2]);
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            if ($order->price <= User::where('id', Auth::id())->first()->account) {
                User::where('id', Auth::id())->update(['account' => Auth::user()->account - $order->price]);
                OrderModel::where('id', $order->id)->update(['status' => 2]);
                return redirect(route('order.status', ['no' => $order['no']]));
            }
        }


        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay = new PayController;
            $payPage = $pay->orderPay($payPlugin, $request['payment'], $order);
            switch ($payPage['type']) {
                case "qrcode":
                    return view(ThemeController::backThemePath('pay', 'home.goods'), compact('order', 'payPage'));
                    break;
                case "redirect":
                    return redirect($payPage['url']);
                    break;
            }
        }
        return redirect(route('order.show')); //默认返回
    }

    /**
     * 检测支付状态并开通主机
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function orderCheckStatusAction(Request $request)
    {
        $this->validate($request, [
            'no' => 'exists:orders,no|required'
        ]);
        //TODO 定义好type类型改为switch判断
        $order = OrderModel::where('no', $request['no'])->first();//获取订单
        if ($order->status == 2 && $order->type == "new") {//判断是否新购订单
            if (empty($order->host_id)) { //判断是否有主机
                $host = new HostController();
                $status = $host->createHost($order);
                if ($status) {
                    return redirect(route('host.show'));
                }
            }
            return redirect(route('order.show'));
        }

        if ($order->status == 2 && $order->type == "renew") { //续费订单
            $host = new HostController();
            $status = $host->renewHostAction($order);
            if ($status) {
                return redirect(route('host.show'));
            }
        }

        if ($order->status == 1) {//订单未支付的时候返回列表
            return redirect(route('order.show')); //默认返回
        }
    }

    /**
     * 订单编辑
     */
    public function orderEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'no' => 'exists:orders,no|required',
            'price' => 'numeric|required'
        ]);
        OrderModel::where('no', $request['no'])->update(['price' => $request['price']]);
        return redirect(route('admin.order.show'));
    }
}

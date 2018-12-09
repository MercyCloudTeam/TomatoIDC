<?php

namespace App\Http\Controllers;

use App\GoodModel;
use App\HostModel;
use App\Http\Controllers\MailDrive\UserMailController;
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
     * 生成订单
     * @param $good_id
     * @param $price
     * @param $user_id
     * @param null $type
     * @param null $aff_no
     * @return mixed
     */
    protected function makeOrder($good_id, $price, $user_id, $type = null, $aff_no = null)
    {
        $no = date('y') . mt_rand(10, 99) . substr(time(), 6) . mt_rand(100, 999);
        $order = OrderModel::create([
            'good_id' => $good_id,
            'user_id' => $user_id,
            'no' => $no,
            'type' => $type,
            'aff_no' => $aff_no,
            'price' => round(abs($price), 2),
        ]);
        return $order;
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
        $good = GoodModel::where('id', $host->order->good->id)->first();
        $order = $this->makeOrder($good->id, $good->price, Auth::id(), 'renew', $request['no']);

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
            return $pay->payPage($payPage);

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

        $good = GoodModel::where('id', $request['id'])->first();

        $order = $this->makeOrder($good->id, $good->price, Auth::id(), 'new', $request['no']);

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
            return $pay->payPage($payPage);
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
            return $pay->payPage($payPage);
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
        return $this->orderCheckStatusFun($request['no']);
    }

    public function orderPaySendMail($user,$order)
    {

        if (!empty(UserMailController::userEmailNoticeSetting())) {
            $mailDrive = new UserMailController();
            $mailDrive->sendMailFun($user, 'UserOrderPay', $order);

        }
    }

    /**
     * 非路由跳转调用检查订单状态
     * @param $no
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function orderCheckStatusFun($no)
    {
        $order = OrderModel::where('no', $no)->first();//获取订单
        if ($order->status == 2 && $order->type == "new") {//判断是否新购订单
            if (empty($order->host_id)) { //判断是否有主机
                $this->orderPaySendMail($order->user,$order);
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

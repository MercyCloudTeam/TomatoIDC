<?php

namespace App\Http\Controllers;

use App\GoodModel;
use App\HostModel;
use App\Http\Controllers\MailDrive\UserMailController;
use App\Http\Controllers\Payment\PayController;
use App\OrderModel;
use App\SettingModel;
use App\User;
use function GuzzleHttp\Psr7\uri_for;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
    protected function makeOrder($good_id, $price, $user_id, $type = null, $aff_no = null, $domain = null)
    {
        $good = GoodModel::where('id', $good_id)->first();

        if ($good->inventory !== null) {

            if ($good->inventory <= 0) {//商品已售空
                return false;
            }
        }
        if (!empty($good->purchase_limit) && $good->purchase_limit != 0) {
            $numOrder = OrderModel::where(
                [
                    ['status', '!=', 0],
                    ['good_id', $good_id],
                    ['user_id', $user_id]
                ]
            )->get()
            ;
            if ($numOrder->count() >= $good->purchase_limit) {
                return false;//超过限购
            }
        }
        //订单创建
        $no    = date('y') . mt_rand(1000, 9999) . substr(time(), 7) . mt_rand(100, 999);
        $order = OrderModel::create(
            [
                'good_id' => $good_id,
                'user_id' => $user_id,
                'no'      => $no,
                'type'    => $type,
                'aff_no'  => $aff_no,
                'price'   => sprintf("%01.2f", $price),
                'domain'  => $domain
            ]
        );
        $this->subGoodInventory($order->no);//扣除库存
        return $order;
    }

    /**
     * 减少库存
     * @param integer $order
     * @return bool
     */
    public function subGoodInventory($order_no)
    {
        $order   = OrderModel::where('no', $order_no)->first();
        $setting = SettingModel::where('name', 'setting.website.good.inventory')->get();
        if ($setting->isEmpty()) {
            $setting = 1;
        }

        $setting = $setting->first()->value;

        if ($order->good->inventory == null) {//库存无限则不执行操作
            return true;
        }
        //        dd($order->count());
        //        dd(123);
        //        dd($order->good_id);
        if ($setting == 1) { //mode 1 付款后扣库存
            if ($order->status == 2) {
                $good = GoodModel::where('id', $order->good_id)->update(['inventory' => $order->good->inventory - 1]);
                return $good;
            }
        }
        if ($setting == 2) { //mode 2 创建订单 付款前扣库存
            if ($order->status == 1) {
                $good = GoodModel::where('id', $order->good_id)->update(['inventory' => $order->good->inventory - 1]);
                return $good;
            }
        }
        return false;
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
        $this->validate(
            $request, [ //验证
                        'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
                        'id'      => 'exists:hosts,id|required',
                        'aff_no'  => 'string|nullable',
                    ]
        );

        $host = HostModel::where('id', $request['id'])->first();
        $this->authorize('update', $host);//防止越权
        //创建订单
        $good  = GoodModel::where('id', $host->order->good->id)->first();
        $order = $this->makeOrder($good->id, $good->price, Auth::id(), 'renew', $request['no']);

        if (!$order) {
            return back()->with(['status' => 'failure', 'text' => "无法下单"]);
        }

        OrderModel::where('no', $order->no)->update(['host_id' => $host->id]);
    
        if (!$order) { //错误提醒
            return redirect(route('order.show'))->with(['status' => 'failure', 'text' => "超过限购或库存已空"]);
        }

        if (!$good->price) {//白嫖 免费
            OrderModel::where('id', $order->no)->update(['status' => 2]);
            $this->subGoodInventory($order->no);//扣除库存
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            $status = $this->accountPay($order, Auth::user());
            if ($status) {
                return $status;
            } else {
                return redirect(route('order.show'))->with(['status' => 'failure', 'text' => '余额不足']);
            }
        }

        //微信支付宝调用插件
        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay     = new PayController;
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
        $this->validate(
            $request, [ //验证
                        'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
                        'id'      => 'exists:goods,id|required',
                        'aff_no'  => 'string|nullable',
                    ]
        );
        $good = GoodModel::where('id', $request['id'])->first();

        if ($good->domain_config) {
            $this->validate(
                $request, [
                            'domain' => ['string', 'unique:orders', 'min:3', 'max:100', 'regex:/^([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i'],
                        ]
            );

        } else {
            $this->validate(
                $request, [
                            'domain' => 'nullable|unique:orders|string|min:3|max:100'
                        ]
            );
            if (empty($request['domain'])) {
                $request['domain'] = null;
            }
        }

        $order = $this->makeOrder($good->id, $good->price, Auth::id(), 'new', $request['no'], $request['domain']);

        if (!$order) { //错误提醒
            return redirect(route('order.show'))->with(['status' => 'failure', 'text' => "超过限购或库存已空"]);
        }

        if (!(int)$good->price) {//白嫖 免费
            OrderModel::where('no', $order->no)->update(['status' => 2]);
            $this->subGoodInventory($order->no);//扣除库存
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            $status = $this->accountPay($order, Auth::user());
            if ($status) {
                return $status;
            } else {
                return redirect(route('order.show'))->with(['status' => 'failure', 'text' => '余额不足']);
            }
        }

        //微信支付宝调用插件
        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay     = new PayController;
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
        $this->validate(
            $request, [
                        'payment' => 'in:wechat,alipay,diy,qqpay,account|string',
                        'no'      => 'exists:orders,no|required',
                    ]
        );
        $order = OrderModel::where('no', $request['no'])->first();

        $this->authorize('view', $order);//防止越权

        //下单不支付，但库存已被别人清空,模式1的时候可能会出现的情况
        if ($order->good->inventory !== null) {
            if ($order->good->inventory == 0) {
                return redirect(route('order.show'))->with(['status' => 'failure', 'text' => "订单已过期"]);
            }
        }

        if ($order->status != 1) { //验证
            return redirect(route('order.show'));
        }

        if (!(int)$order->price) {//白嫖 免费
            OrderModel::where('no', $order->no)->update(['status' => 2]);
            return redirect(route('order.status', ['no' => $order['no']]));
        }

        if ($request['payment'] == "account") { //余额支付
            $status = $this->accountPay($order, Auth::user());
            if ($status) {
                return $status;
            } else {
                return redirect(route('order.show'))->with(['status' => 'failure', 'text' => '余额不足']);
            }
        }


        $payPlugin = SettingModel::where('name', 'setting.website.payment.' . $request['payment'])->first();
        $payPlugin = $payPlugin['value'];
        if (!empty($payPlugin)) {
            $pay     = new PayController;
            $payPage = $pay->orderPay($payPlugin, $request['payment'], $order);
            return $pay->payPage($payPage);
        }
        return redirect(route('order.show')); //默认返回
    }

    /**
     * 余额支付
     * @param OrderModel $order 订单
     * @param $user User 用户
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector 成功返回跳转，失败返回false
     */
    protected function accountPay(OrderModel $order, $user)
    {
        //        dd(33.12 <= 32.33);
        $compare = bccomp($user->account, $order->price, 2);

        if ($compare == 1 xor $compare == 0) {
            if (
            User::where('id', $user->id)->update( //余额支付失败
                ['account' => bcsub($user->account, $order->price, 2)]
            )
            ) {
                OrderModel::where('no', $order->no)->update(['status' => 2]);
                //                dd($order->no);
                $this->subGoodInventory($order->no);//扣除库存
                return redirect(route('order.status', ['no' => $order['no']]));
            }
            Log::debug("account pay error", [$order, $user]);
        }
        return false;
    }

    /**
     * 检测支付状态并开通主机
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function orderCheckStatusAction(Request $request)
    {
        $this->validate(
            $request, [
                        'no' => 'exists:orders,no|required'
                    ]
        );
        //TODO 定义好type类型改为switch判断
        return $this->orderCheckStatusFun($request['no']);
    }

    /**
     * 发送邮件
     * @param $user
     * @param $order
     */
    public function orderPaySendMail($user, $order)
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

        //订单支付成功执行的操作
        if ($order->status == 2 && $order->type == "new") {//判断是否新购订单
            if (empty($order->host_id)) { //判断是否有主机
                $this->orderPaySendMail($order->user, $order);
                $host   = new HostController();
                $status = $host->createHost($order);
                if ($status) {
                    return redirect(route('host.show'))->with(['status' => 'success']);
                }
            }
            return redirect(route('order.show'));
        }

        if ($order->status == 2 && $order->type == "renew") { //续费订单
            $host   = new HostController();
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
     * 管理员订单编辑
     */
    public function orderEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'no'     => 'exists:orders,no|required',
                        'price'  => 'numeric|required',
                        'domain' => 'string|unique:orders|nullable'
                    ]
        );
        OrderModel::where('no', $request['no'])->update(['price' => $request['price'], 'domain' => $request['domain']]);
        return redirect(route('admin.order.show'));
    }
}

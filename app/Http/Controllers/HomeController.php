<?php

namespace App\Http\Controllers;

use App\GoodModel;
use App\HostModel;
use App\NewModel;
use App\OrderModel;
use App\User;
use App\WorkOrderModel;
use App\WorkOrderReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/**
 * 用户中心所有页面返回
 * TODO 各功能代码拆分
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户首页代码
     * @return \Illuminate\Http\Response
     */
    public function indexPage()
    {
        $orders = OrderModel::where([
            ['status', '!=', '1'],
            ['status', '!=', '0'],
            ['type', 'new'],
            ['user_id', Auth::id()]
        ])->orderBy('created_at', 'desc')
            ->paginate(8);
        !$orders->isEmpty() ?: $orders = null;
        return view(ThemeController::backThemePath('index', 'home'), compact('orders'));
    }

    /**
     * 用户设置
     */
    public function userProfilePage()
    {
        return view(ThemeController::backThemePath('profile', 'home'));
    }

    /**
     * 主机列表页面
     */
    public function hostShowPage()
    {
        $hosts = HostModel::where([
            ['status', '!=', '0'],
            ['user_id', Auth::id()]
        ])->orderBy('created_at', 'desc')
            ->paginate(10);
        !$hosts->isEmpty() ?: $hosts = null;
        return view(ThemeController::backThemePath('show', 'home.hosts'), compact('hosts'));
    }

    /**
     * 主机列表页面
     */
    public function renewHostPage($id)
    {
        $host = HostModel::where('id', htmlspecialchars(trim($id)))->get();
        if (!$host->isEmpty()) {
            $host = $host->first();
            $this->authorize('view', $host);
            return view(ThemeController::backThemePath('renew', 'home.hosts'), compact('host'));
        }
        return redirect(route('order.show')); //错误返回
    }

    /**
     * 重新支付
     */
    public function rePayOrderPage($no)
    {
        $order = OrderModel::where('no', htmlspecialchars(trim($no)))->get();
        if (!$order->isEmpty()) {
            $order = $order->first();

            if ($order->status != 1) { //验证
                return redirect(route('order.show'));
            }
            $this->authorize('view', $order);
            return view(ThemeController::backThemePath('repay', 'home.orders'), compact('order'));
        }
        return redirect(route('order.show')); //错误返回
    }


    /**
     * 商品购买
     */
    public function goodsBuyPage($id)
    {
        $good = GoodModel::where('id', $id)->get();
        if (!$good->isEmpty()) {
            $good = $good->first();
            return view(ThemeController::backThemePath('buy', 'home.goods'), compact('good'));
        }
        return redirect(route('good.show')); //错误返回
    }

    /**
     * 工单添加页面返回
     */
    public function workOrderAddPage()
    {
        return view(ThemeController::backThemePath('add', 'home.work_order'));
    }

    /**
     * 工单列表页面返回
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function workOrderShowPage()
    {
        $workOrder = WorkOrderModel::where([
            ['status', '!=', '0'],
            ['user_id', Auth::id()]
        ])->orderBy('created_at', 'desc')
            ->paginate(8);
        return view(ThemeController::backThemePath('show', 'home.work_order'), compact('workOrder'));
    }
//    public function msgShowPage()
//    {
//        return view(ThemeController::backThemePath('show','home.msgs'));
//    }

    /**
     * 获取订单
     */
    protected function getOrder($id)
    {
        $orders = OrderModel::
        where([
            ['status', '!=', '0'],
            ['user_id', $id]
        ])->orderBy('created_at', 'desc')
            ->paginate(10);
        !$orders->isEmpty() ?: $orders = null;
        return $orders;
    }

    /**
     * 新闻列表页面
     */
    public function newShowPage()
    {
        $news = NewModel::where([
            ['status', '!=', '0'],
        ])->orderBy('created_at', 'desc')
            ->paginate(10);
        return view(ThemeController::backThemePath('show', 'home.news'), compact('news'));
    }

    /**
     * 公告新闻内容
     */
    public function newPostPage($id)
    {
        $new = NewModel::where('id', $id)->get();
        if (!$new->isEmpty()) {
            $new = $new->first();
        } else {
            return back();
        }
        return view(ThemeController::backThemePath('posts', 'home.news'), compact('new'));

    }

    /**
     * 主机详细页面
     */
    public function hostDetailedPage($id)
    {
        $host = HostModel::where('id', $id)->get();
        if (!$host->isEmpty()) {
            $host = $host->first();
        } else {
            return back();
        }
        $this->authorize('view', $host);//防止越权
        return view(ThemeController::backThemePath('detailed', 'home.hosts'), compact('host'));

    }

    /**
     * 工单详细页面
     */
    public function workOrderDetailedPage($id)
    {
        $workOrder = WorkOrderModel::where('id', $id)->get();
        if (!$workOrder->isEmpty()) {
            $workOrder = $workOrder->first();
            $reply = WorkOrderReplyModel::where('work_order_id', $workOrder->id)->get();
            !$reply->isEmpty() ?: $reply = null;//防止报错
            $this->authorize('view', $workOrder); //防止越权
            return view(ThemeController::backThemePath('detailed', 'home.work_order'), compact('workOrder', 'reply'));
        }
        return redirect(route('work.order.show')); //错误返回
    }

    /**
     * 订单详细页面
     */
    public function orderDetailedPage($no)
    {
        $order = OrderModel::where('no', $no)->get();
        if (!$order->isEmpty()) {
            $order = $order->first();
            $this->authorize('view', $order); //防止越权
            return view(ThemeController::backThemePath('detailed', 'home.orders'), compact('order'));
        }
        return redirect(route('order.show')); //错误返回
    }

    /**
     * 订单列表页面
     */
    public function orderShowPage()
    {
        $orders = $this->getOrder(Auth::id());
        return view(ThemeController::backThemePath('show', 'home.orders'), compact('orders'));
    }

    /**
     * 用户充值页面
     */
    public function userRechargePage()
    {
        return view(ThemeController::backThemePath('recharge','home'));
    }


    public function userEmailValidatePage()
    {
        return  view(ThemeController::backThemePath('email_validate','home.user'));
    }
}

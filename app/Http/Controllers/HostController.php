<?php

namespace App\Http\Controllers;

use App\GoodConfigureModel;
use App\GoodModel;
use App\HostModel;
use App\Http\Controllers\MailDrive\UserMailController;
use App\Http\Controllers\Server\ServerPluginController;
use App\Mail\UserHostCreate;
use App\OrderModel;
use App\ServerModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{


    /**
     * TODO 开通主机，版本更新设计思路，当用户下单购买主机调用fun时，应异步向api发送请求并通过数据表缓存主机名，开通成功调用函数再更新订单，若未返回，应主动查询主机信息
     */

    /**
     * 操作代码 Action
     */

    /**
     * send mail for new buy user
     * @param $user
     * @param $host
     */
    protected function hostNewSendMail($user, $host)
    {
        if (!empty(UserMailController::userEmailNoticeSetting())) {
            $mailDrive = new UserMailController();
            $mailDrive->sendMailFun($user, 'UserHostCreate', $host);

        }
    }

    /**
     * 创建主机
     * @param $order
     * @return bool
     */
    public function createHost($order)
    {
        $good = GoodModel::where('id', $order->good_id)->first();
        if (!empty($good->server_id) && !empty($good->configure_id)) {
            // 获取信息
            $server           = ServerModel::where('id', $good->server_id)->first();
            $configure        = GoodConfigureModel::where('id', $good->configure_id)->first();
            $serverController = new ServerPluginController();

            //尝试开通
            if (empty($configure) or empty($server)) {
                OrderModel::where('id', $order->id)->update(['status' => 3]);
                return false;//商品配置错误，则订单状态改为等待审核
            } else
                $host = $serverController->createHost($server, $configure, $order);
            if ($host) {
                //开通成功后执行代码
                if (!empty($configure->time)) {//添加截止时间
                    HostModel::where('id', $host->id)->update(['deadline' => Carbon::now()->addDays($configure->time)]);
                }
                $this->hostNewSendMail($host->user, $host);
                return OrderModel::where('id', $order->id)->update(['host_id' => $host->id]);
            } else {
                OrderModel::where('id', $order->id)->update(['status' => 3]);
                return false;
            }
        }
        //默认错误返回
        OrderModel::where('id', $order->id)->update(['status' => 3]);
        return false;
    }

    /**
     * 重新开通主机
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reCreateHost(Request $request)
    {
        $this->validate(
            $request, [
                        'no' => 'exists:orders,no|required'
                    ]
        );
        $order = OrderModel::where('no', $request['no'])->first();
        //        dd($order);
        //        dd($order->status);
        //TODO 切换成switch判断
        if ($order->status == 3 && $order->type == "new") {
            $status = $this->createHost($order);
            if ($status) {
                OrderModel::where('no', $request['no'])->update(['status' => '2']);
                return back()->with(['status' => 'success']);
            }
        }
        return back()->with(['status' => 'failure']);
    }


    /**
     * 检测所有主机状态
     */
    public function autoCheckHostStatus()
    {
        $hosts = HostModel::where(
            [ //检测过期主机
              ['status', '1'],
              ['deadline', '<=', Carbon::now()]
            ]
        )->get()
        ;
        if (!$hosts->isEmpty()) {
            foreach ($hosts as $host) {
                $server           = $host->order->good->server;
                $serverController = new ServerPluginController();
                $status           = $serverController->closeHost($server, $host);
                if ($status) {
                    HostModel::where('id', $host->id)->update(['status' => 2]);//标记已停用
                } else {
                    HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
                }
            }
            //            return $hosts;
        }
    }


    /**
     * 管理面板登录
     * @param $id
     */
    public function managePanelLogin(Request $request)
    {
        //验证
        $this->validate(
            $request, [
                        'id' => 'exists:hosts|numeric'
                    ]
        );
        $host = HostModel::where('id', $request['id'])->first();
        $this->authorize('view', $host);
        //逻辑
        if (!empty($host->host_url)) {
            return redirect($host->host_url);
        }
        $server           = $host->order->good->server;
        $serverController = new ServerPluginController();
        $result           = $serverController->managePanelLogin($server, $host);
        if (!empty($result)) {
            return redirect($result);
        }
        return back()->with(['status' => 'failure', 'text' => '该服务不支持']);
    }

    /**
     * 禁用主机
     */
    public function closeHost(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'id' => 'exists:hosts|required'
                    ]
        );
        $host             = HostModel::where('id', $request['id'])->first();
        $server           = $host->order->good->server;
        $serverController = new ServerPluginController();
        $status           = $serverController->closeHost($server, $host);
        if ($status) {
            HostModel::where('id', $host->id)->update(['status' => 2]);//标记已停用
            return 1;
        } else {
            HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
            return response('error', 500);
        }

    }

    /**
     * 取消禁用
     */
    public function openHost(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'id' => 'exists:hosts|required'
                    ]
        );
        $host             = HostModel::where('id', $request['id'])->first();
        $server           = $host->order->good->server;
        $serverController = new ServerPluginController();
        $status           = $serverController->openHost($server, $host);
        if ($status) {
            HostModel::where('id', $host->id)->update(['status' => 1, 'deadline' => null]);//标记正常,并清空到期时间
            return 1;
        } else {
            HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
            return response('error', 500);
        }
    }

    public function hostEditAction(Request $request)
    {
        $this->validate(
            $request, [
                        'deadline'  => ['string', 'min:3', 'max:100', 'regex:/[0-9]+\/[0-9]+\/[0-9]+/'],
                        'host_pass' => 'string|min:6|max:199',
                        'host_name' => 'string|min:6|max:199',
                        'id'        => 'exists:hosts|required'
                    ]
        );
        $host     = HostModel::where('id', $request['id'])->first();
        $deadline = substr($host->deadline, 5, 2) . "/" .
                    substr($host->deadline, 8, 2) . "/" .
                    substr($host->deadline, 0, 4);
        if ($deadline != $request['deadline']) {
            $year           = substr($request['deadline'], 6, 4);
            $day            = substr($request['deadline'], 3, 2);
            $month          = substr($request['deadline'], 0, 2);
            $data           = Carbon::create($year, $month, $day);
            $host->deadline = $data;
        }
        $host->host_pass == $request['host_pass'] ?: $host->host_pass = $request['host_pass'];
        $host->host_name == $request['host_name'] ?: $host->host_name = $request['host_name'];
        if ($host->save()) {
            return redirect(route('admin.host.show'))->with(['status' => 'success']);
        }
        //        dd(123);
    }

    /**
     * 续费主机 TODO （181212补充，我当时没写TODO啥 现在我忘了要TODO啥了）
     * @param $order
     * @return bool
     */
    public function renewHostAction($order)
    {
        //验证主机是否存在
        if (empty($order->host_id)) {
            return false;
        }

        $host = HostModel::where('id', $order->host_id)->get();
        if ($host->isEmpty()) {
            return false;
        }
        $host = $host->first();
        $good = GoodModel::where('id', $order->good_id)->first();
        if (!empty($good->server_id) && !empty($good->configure_id)) {
            // 获取信息
            $server           = ServerModel::where('id', $good->server_id)->first();
            $configure        = GoodConfigureModel::where('id', $good->configure_id)->first();
            $serverController = new ServerPluginController();

            //通知插件更新
            if (empty($configure) && empty($server)) { //商品配置错误，则订单状态改为等待审核
                OrderModel::where('id', $order->id)->update(['status' => 3]);
                return false;
            } else//调用创建函数
                $status = $serverController->renewHost($server, $configure, $order, $host);
            if ($status) {
                //开通成功后执行代码
                if (!empty($configure->time && !empty($host->deadline))) {//添加截止时间
                    HostModel::where('id', $host->id)->update(['deadline' => Carbon::parse($host->deadline)->addDays($configure->time)]);
                }
                return OrderModel::where('id', $order->id)->first();
            } else {
                OrderModel::where('id', $order->id)->update(['status' => 3]);
                return false;
            }
        }
        //默认错误返回
        OrderModel::where('id', $order->id)->update(['status' => 3]);
        return false;
    }
}

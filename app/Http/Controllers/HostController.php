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

class HostController extends Controller
{


    /**
     * 操作代码 Action
     */

    /**
     * send mail for new buy user
     * @param $user
     * @param $host
     */
    protected function hostNewSendMail($user,$host)
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
            $server = ServerModel::where('id', $good->server_id)->first();
            $configure = GoodConfigureModel::where('id', $good->configure_id)->first();
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
                $this->hostNewSendMail($host->user,$host);
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
        $this->validate($request, [
            'id' => 'exists:orders,id|required'
        ]);
        $order = OrderModel::where('id', $request['id'])->first();
        //TODO 切换成switch判断
        if ($order->status == 3 && $order->type == "new") {
            $status = $this->createHost($order);
            if ($status) {
                OrderModel::where('id', $request['id'])->update(['status' => '2']);
                return back();
            }
        }
        return back();
    }


    /**
     * 检测所有主机状态
     */
    public function autoCheckHostStatus()
    {
        $hosts = HostModel::where([ //检测过期主机
            ['status', '1'],
            ['deadline', '<=', Carbon::now()]
        ])->get();
        if (!$hosts->isEmpty()) {
            foreach ($hosts as $host) {
                $server = $host->order->good->server;
                $serverController = new ServerPluginController();
                $status = $serverController->closeHost($server, $host);
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
     * 续费主机 TODO
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
            $server = ServerModel::where('id', $good->server_id)->first();
            $configure = GoodConfigureModel::where('id', $good->configure_id)->first();
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

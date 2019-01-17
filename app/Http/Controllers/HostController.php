<?php

namespace App\Http\Controllers;

use App\ChargingModel;
use App\GoodConfigureModel;
use App\GoodModel;
use App\HostModel;
use App\Http\Controllers\MailDrive\UserMailController;
use App\Http\Controllers\Server\ServerPluginController;
use App\Mail\UserHostCreate;
use App\OrderModel;
use App\ServerModel;
use App\SettingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
     * 给主机重写到期时间
     * @param $order
     * @param $host
     */
    protected function addTime($order, $host)
    {
        $configure = json_decode($order->json_configure);
        if (empty($configure->type) && empty($configure->id)) {
            Log::info('订单出现配置错误，请检查', [$order]);
            HostModel::where('id', $host->id)->update(['deadline' => Carbon::now()->addDays(1)]);
        }

        switch ($order->type){
            case 'new':
                $time = Carbon::now();
                break;
            case 'renew':
                $time = Carbon::parse($host->deadline);
                break;
            default:
                $time = Carbon::now();

        }

//        dd($time,$configure);
        switch ($configure->type) {
            case "multicycle":
                $charging = ChargingModel::where('id', $configure->id)->get();
                if ($charging->isEmpty()) {
                    Log::info('订单出现配置错误，请检查', [$order]);
                    HostModel::where('id', $host->id)->update(['deadline' => $time->addDays(1)]);
                }
                $charging = $charging->first();
                //TODO 历史遗留 待重构
                if (config('app.locale') != "zh-CN") {
                    switch ($charging->unit) {
                        case "day":
                            HostModel::where('id', $host->id)->update(['deadline' => $time->addDays($charging->time)]);
                            break;
                        case "month":
                            HostModel::where('id', $host->id)->update(['deadline' => $time->addMonths($charging->time)]);
                            break;
                        case  "year":
                            HostModel::where('id', $host->id)->update(['deadline' => $time->addYears($charging->time)]);
                            break;
                    }
                }

                switch ($charging->unit) {
                    case "天":
                        HostModel::where('id', $host->id)->update(['deadline' => $time->addDays($charging->time)]);
                        break;
                    case "月":
                        HostModel::where('id', $host->id)->update(['deadline' => $time->addMonths($charging->time)]);
                        break;
                    case  "年":
                        HostModel::where('id', $host->id)->update(['deadline' => $time->addYears($charging->time)]);
                        break;
                }

                break;
            case "disposable":
                HostModel::where('id', $host->id)->update(['deadline' => $time->addYears(10)]);
                break;
            case "month_price":
                HostModel::where('id', $host->id)->update(['deadline' => $time->addMonths(1)]);
                break;

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
                $order->status = 3;
                $order->save();
                return false;//商品配置错误，则订单状态改为等待审核
            }
            $host = $serverController->createHost($server, $configure, $order);
            if ($host) {
                $this->addTime($order, $host);
                //开通成功后执行代码
//                dd($order->json_configure);
//                if ($order->json_configure)
//                if (!empty($configure->time)) {//添加截止时间
//                    HostModel::where('id', $host->id)->update(['deadline' => Carbon::now()->addDays($configure->time)]);
//                }
                $this->hostNewSendMail($host->user, $host);
                $order->host_id = $host->id;
                $order->status = 2;
                $order->save();
                return $order;
            }
        }
        //默认错误返回
        $order->status = 3;
        $order->save();
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
        AdminController::checkAdminAuthority(Auth::user());
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
     * 重设主机密码
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassHost(Request $request)
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
        $server = $host->order->good->server;
        $serverController = new ServerPluginController();
        $result = $serverController->resetPassHost($server, $host);

        if (!empty($result)) {
            return 1;
        }
        return response('error', 500);
    }

    /**
     * 释放主机
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function terminateHost(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                'id' => 'exists:hosts|required'
            ]
        );
        $host = HostModel::where('id', $request['id'])->first();
        $server = $host->order->good->server;
        $serverController = new ServerPluginController();
        $status = $serverController->terminateHost($server, $host);
        if ($status) {
            HostModel::where('id', $host->id)->update(['status' => 4]);//标记已释放
            return 1;
        } else {
            HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
            return response('error', 500);
        }
    }

    /**
     * 自动永久删除主机
     */
    public function autoTerminateHost()
    {
        $setting = SettingModel::where('name', 'setting.expire.terminate.host.data')->get();
        if ($setting->isEmpty()) {
            $day = 10;
        } else {
            $day = (int)$setting->first()->value;
        }
        $hosts = HostModel::where(
            [
                ['status', '2'],
                ['deadline', '<=', Carbon::now()->addDay($day)]
            ]
        )->get();
        if (!$hosts->isEmpty()) {
            foreach ($hosts as $host) {
                $server = $host->order->good->server;
                $serverController = new ServerPluginController();
                $status = $serverController->TerminateHost($server, $host);
                if ($status) {
                    HostModel::where('id', $host->id)->update(['status' => 4]);//标记资源已永久删除
                } else {
                    HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
                }
            }
        }
    }


    /**
     * 自动创建主机
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function autoCheckAsyncCreateHost()
    {
        //异步开通
        $async = SettingModel::where('name', 'setting.async.create.host')->get();
        if (!$async->isEmpty() && $async->first()->value == 1) {
            $orders = OrderModel::where(
                [
                    ['status', 4],
                ]
            )->lockForUpdate()->get();
            foreach ($orders as $order) {
                $host = new HostController();
                $status = $host->createHost($order);
//                if ($status) {
//                    return redirect(route('host.show'))->with(['status' => 'success']);
//                }else{
//                    return redirect(route('order.show'));
//                }
            }
        }
        return true;
    }


    /**
     * 检测所有主机状态 并自动停用
     */
    public function autoCheckHostStatus()
    {
        $hosts = HostModel::where(
            [ //检测过期主机
                ['status', '1'],
                ['deadline', '<=', Carbon::now()]
            ]
        )->get();
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
     * 管理面板登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
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
        $server = $host->order->good->server;
        $serverController = new ServerPluginController();
        $result = $serverController->managePanelLogin($server, $host);
        if (!empty($result)) {
            switch ($result['type']) {
                case 'url':
                    return redirect($result['content']);
                    break;
                case 'from_base64':
                    return base64_decode($result['content']);
            }
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
        $host = HostModel::where('id', $request['id'])->first();
        $server = $host->order->good->server;
        $serverController = new ServerPluginController();
        $status = $serverController->closeHost($server, $host);
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
        $host = HostModel::where('id', $request['id'])->first();
        $server = $host->order->good->server;
        $serverController = new ServerPluginController();
        $status = $serverController->openHost($server, $host);
        if ($status) {
            HostModel::where('id', $host->id)->update(['status' => 1, 'deadline' => null]);//标记正常,并清空到期时间
            return 1;
        } else {
            HostModel::where('id', $host->id)->update(['status' => 3]);//标记出错
            return response('error', 500);
        }
    }

    /**
     * 编辑主机
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function hostEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                'deadline' => ['string', 'min:3', 'max:100', 'regex:/[0-9]+\/[0-9]+\/[0-9]+/'],
                'host_pass' => 'string|min:6|max:199',
                'host_name' => 'string|min:6|max:199',
                'id' => 'exists:hosts|required'
            ]
        );
        $host = HostModel::where('id', $request['id'])->first();
        $deadline = substr($host->deadline, 5, 2) . "/" .
            substr($host->deadline, 8, 2) . "/" .
            substr($host->deadline, 0, 4);
        if ($deadline != $request['deadline']) {
            $year = substr($request['deadline'], 6, 4);
            $day = substr($request['deadline'], 3, 2);
            $month = substr($request['deadline'], 0, 2);
            $data = Carbon::create($year, $month, $day);
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
                //更新订单
                HostModel::where('id', $order->host_id)->update(['order_id' => $order->id]);
                $this->addTime($order,$host);
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

<?php

namespace App\Http\Controllers;

use App\WorkOrderModel;
use App\WorkOrderReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yansongda\Pay\Log;

class WorkOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 工单添加操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workOrderAddAction(Request $request)
    {
        $this->validate(
            $request, [
                        'title'    => 'string|min:3|max:200',
                        'content'  => 'string|min:3|max:999',
                        'order_no' => 'exists:orders,no|nullable',
                        'priority' => 'in:1,2,3|nullable'
                    ]
        );

        if (WorkOrderModel::where([['user_id', Auth::id()], ['status', '!=', 3]])->get()->count() >= 20) {
            return redirect(route('work.order.show'))->with(['status' => 'failure', 'text' => "未处理的工单太多了"]);
        }

        WorkOrderModel::create(
            [
                'title'    => $request['title'],
                'content'  => $request['content'],
                'user_id'  => Auth::id(),
                'order_no' => $request['order_no'],
                'priority' => $request['priority']
            ]
        );


        return redirect(route('work.order.show'));
    }

    /**
     * 关闭工单操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workOrderCloseAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'id' => 'exists:work_order,id|required'
                    ]
        );
        WorkOrderModel::where('id', $request['id'])->update(['status' => 4]);
        return redirect(route('admin.work.order.show'));
    }

    /**
     * 管理员工单回复操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workOrderAdminReplyAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'id'      => 'exists:work_order,id|required',
                        'content' => 'string|min:3|max:200'
                    ]
        );
        WorkOrderReplyModel::create(
            [
                'work_order_id' => $request['id'],
                'content'       => $request['content'],
                'user_id'       => Auth::id()
            ]
        );
        WorkOrderModel::where('id', $request['id'])->update(['status' => 2]);
        return back()->with(['status' => 'success']);
    }

    /**
     * 工单回复操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workOrderReplyAction(Request $request)
    {
        $this->validate(
            $request, [
                        'id'      => 'exists:work_order,id|required',
                        'content' => 'string|min:3|max:200'
                    ]
        );
        WorkOrderReplyModel::create(
            [
                'work_order_id' => $request['id'],
                'content'       => $request['content'],
                'user_id'       => Auth::id()
            ]
        );
        WorkOrderModel::where('id', $request['id'])->update(['status' => 1]);
        return back()->with(['status' => 'success']);
    }
}

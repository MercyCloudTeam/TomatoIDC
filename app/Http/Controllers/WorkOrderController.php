<?php

namespace App\Http\Controllers;

use App\WorkOrderModel;
use App\WorkOrderReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'content' => 'string|min:3|max:999'
        ]);

        WorkOrderModel::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'user_id' => Auth::id(),
        ]);

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
        $this->validate($request, [
            'id' => 'exists:work_order,id|required'
        ]);
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
        $this->validate($request, [
            'id' => 'exists:work_order,id|required',
            'content' => 'string|min:3|max:200'
        ]);
        WorkOrderReplyModel::create([
            'work_order_id' => $request['id'],
            'content' => $request['content'],
            'user_id' => Auth::id()
        ]);
        WorkOrderModel::where('id', $request['id'])->update(['status' => 2]);
        return redirect(route('admin.work.order.show'));
    }

    /**
     * 工单回复操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function workOrderReplyAction(Request $request)
    {
        $this->validate($request, [
            'id' => 'exists:work_order,id|required',
            'content' => 'string|min:3|max:200'
        ]);
        WorkOrderReplyModel::create([
            'work_order_id' => $request['id'],
            'content' => $request['content'],
            'user_id' => Auth::id()
        ]);
        WorkOrderModel::where('id', $request['id'])->update(['status' => 1]);
        return redirect(route('work.order.show'));
    }
}

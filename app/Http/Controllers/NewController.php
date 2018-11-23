<?php

namespace App\Http\Controllers;

use App\NewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewController extends Controller
{

    /**
     * 操作代码 Action
     */
    /**
     * 新增新闻操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());//验证
        $this->validate($request, [
            'title' => 'min:3|max:200|string',
            'subtitle' => 'min:3|max:200|string',
            'description' => 'min:3|max:200|string',
        ]);
        //逻辑
        NewModel::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'description' => $request['description'],
            'user_id' => Auth::id()
        ]);

        return redirect(route('admin.new.show'));
    }

    /**
     * 新闻编辑
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());//验证
        $this->validate($request, [
            'title' => 'min:3|max:200|string',
            'subtitle' => 'min:3|max:200|string',
            'description' => 'min:3|max:200|string',
            'id' => 'exists:news,id|required'
        ]);
        //逻辑
        NewModel::where(['id' => $request['id']])->update([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'description' => $request['description'],
            'user_id' => Auth::id()
        ]);

        return redirect(route('admin.new.show'));
    }

    /**
     * 新闻软删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function newDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'id' => 'exists:goods_categories,id|required'
        ]);
        NewModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.new.show'));
    }
}

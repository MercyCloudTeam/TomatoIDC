<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Server\ServerPluginController;
use App\OrderModel;
use App\ServerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
{

    /**
     * 服务器编辑
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function serverEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'min:3|max:200|string',
            'ip' => 'min:3|string',
            'key' => 'string|nullable|min:3|max:200',
            'plugin' => 'string|nullable|min:3|max:200',
            'port' => 'integer|nullable|min:1',
            'id' => 'exists:servers,id|required',
            'token' => 'nullable|min:1|max:200',
            'username' => 'nullable|min:1|max:200',
            'password' => 'nullable|min:1|max:200',
        ]);

        ServerModel::where('id', $request['id'])->update([
            'title' => $request['title'],
            'ip' => $request['ip'],
            'key' => $request['key'],
            'plugin' => $request['plugin'],
            'port' => $request['port'],
            'token' => $request['token'],
            'username' => $request['username'],
            'password' => $request['password'],
        ]);

        return redirect(route('admin.server.show'));
    }

    /**
     * 服务器删除操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function serverDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'id' => 'exists:servers,id|required'
        ]);
        ServerModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.server.show'));
    }


    /**
     * 添加服务器操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function serverAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'min:3|max:200|string',
            'ip' => 'min:3|string',
            'key' => 'string|nullable|min:3|max:200',
            'plugin' => 'string|nullable|min:3|max:200',
            'port' => 'nullable|min:1|max:200',
            'token' => 'nullable|min:1|max:200',
            'username' => 'nullable|min:1|max:200',
            'password' => 'nullable|min:1|max:200',
        ]);

        ServerModel::create([
            'title' => $request['title'],
            'ip' => $request['ip'],
            'key' => $request['key'],
            'plugin' => $request['plugin'],
            'port' => $request['port'],
            'token' => $request['token'],
            'username' => $request['username'],
            'password' => $request['password'],
        ]);

        return redirect(route('admin.server.show'));
    }

    /**
     * 获取服务器状态
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function serverStatusPage($id)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $server = ServerModel::where('id', $id)->get();
        if (!$server->isEmpty()) {
            $server = $server->first();
            if (empty($server->plugin)) {
                return redirect(route('admin.server.show'));
            }//如果为设置插件则返回
            $plugin = new  ServerPluginController();
            $result = $plugin->serverStatus($server);
            if ($result) {
                //!$orders->isEmpty()?: $orders=null;
                return view(ThemeController::backAdminThemePath('status', 'servers'), compact('result'));
            }
        }
        return redirect(route('admin.server.show'));

    }
}

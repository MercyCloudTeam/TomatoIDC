<?php

namespace App\Http\Middleware;

use App\User;
use App\SettingModel;
use Closure;

class CheckInstallStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!empty(config('database.connections.mysql.database'))) { //数据表未设置
            if (
                !SettingModel::where('name', '=', 'setting.install.status')->get()->isEmpty() or
                SettingModel::all()->count() or
                !User::where('id', 1)->get()->isEmpty()
            ) {
                if ($request->path() == 'install/init') {
                    return redirect('/');
                }
            } else {
                if ($request->path() != "install/init") {//自动跳转安装页面
                    return redirect('/install/init');
                }
            }
            return $next($request);
        }
    }
}

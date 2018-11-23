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
        if (!SettingModel::where('name', '=', 'setting.install.status')->get()->isEmpty()) {
            return redirect('/');
        }
        if (SettingModel::all()->count()) {
            return redirect('/');
        }
        return $next($request);
    }
}

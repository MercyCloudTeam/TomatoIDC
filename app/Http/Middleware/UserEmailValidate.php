<?php

namespace App\Http\Middleware;

use App\SettingModel;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserEmailValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mode = SettingModel::where('name', 'setting.website.user.email.validate')->first()->value;
        if ($mode == 0) {
            return $next($request);
        }
        $email_vaildate = Auth::user()->email_validate;
        if ($mode == 1){//提示验证
            if ($request->path() == "home/email/validate" && $email_vaildate == 1){ //验证通过就不访问刚刚那个页面了
                return redirect('/home');
            }
            return $next($request);
        }
        if ($mode == 2){//强制验证
            if ($email_vaildate == 1){
                if ($request->path() == "home/email/validate"){ //验证通过就不访问刚刚那个页面了
                    return redirect('/home');
                }
                return $next($request);
            } else {
                if ($request->path() != 'home/email/validate') { //防止无限跳转

                    return redirect(route('user.email.validate'));
                }
            }
        }
            return $next($request);
    }
}

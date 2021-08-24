<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class LanguageMiddleware
{

    /**
     * 支持的语言
     * @var string[]
     */
    protected array $supportLang = [
        'zh-CN',
        'zh-HK',
        'en',
    ];


    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->exists('lang')){
            $userLang = (string) $request->get('lang');
        }elseif(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
            $userLang = (string) $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        }
        if(empty($userLang)){
            $userLang = config('app.locale');
        }
        foreach ($this->supportLang as $support){
            if (str_contains(strtolower(htmlspecialchars($userLang)), strtolower($support))){
                switch ($support){
                    case "zh-HK":
                    case "zh-TW":
                        App::setLocale("zh-HK");
                        break;
                    default:
                        App::setLocale($support);
                }
                return $next($request);
            }
        }
        App::setLocale('zh-CN');
        return $next($request);
    }
}

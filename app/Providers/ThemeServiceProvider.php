<?php

namespace App\Providers;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\Fortify;

class ThemeServiceProvider extends ServiceProvider
{


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 静态资源软连接
        $target = resource_path('themes/' . config('hstack.theme') . '/assets');
        $link =  public_path('assets/theme/' . config('hstack.theme'));
        if (!is_link($link) && !file_exists($link)) {
            (new Filesystem())->link($target, $link);
            // NOTE: 警告用戶不能存儲其他文件，防止安全問題
        }
        // 模板全局变量 , 配置的变量注册代码实现在：app/HStack/SetupManager.php app/Providers/HStackServiceProvider.php
        View::share('themeAssets', 'assets/theme/' . config('hstack.theme'));
        $this->registerPath();
        $this->registerTheme();
    }

    /**
     * 注册路径
     */
    public function registerPath()
    {
        $theme = config('hstack.theme');
        // 加载路径
        $views = resource_path("themes/$theme");
        $this->loadViewsFrom($views, 'theme');

        // 加载翻译
        $lang = resource_path("themes/$theme/lang");
        $this->loadTranslationsFrom($lang, 'theme');  // 除自带翻译外模板的翻译

        //默认分页视图引用
        if (file_exists($views . '/vendor')) {
            Paginator::defaultView("theme::vendor.pagination.default");
            Paginator::defaultSimpleView("theme::vendor.pagination.simple");
        }
        //注册错误路径 app/Exceptions/Handler.php
    }

    /**
     * 加载模板配置
     */
    protected function registerTheme()
    {
        //注册路由
        $theme = config('hstack.theme');
        $routers = json_decode(Cache::get("theme-$theme-routes"));
        if (!empty($routers)){
            $routeList = function (){};
            foreach ($routers as $path=>$page){
                $routeList->bindTo(Route::view($path,"theme::$page"));
            }
            $this->app->router->middleware('web')
                ->group($routeList);
        }
    }
}

<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        $publicAssets = public_path('assets/theme/' . config('hstack.theme'));
        if (!is_link(public_path($publicAssets)) && !file_exists($publicAssets)) {
            $fileSystem = $this->app->files;
            $fileSystem->link(
                resource_path('themes/' . config('hstack.theme') . '/assets'),
                public_path('assets/theme/' . config('hstack.theme'))
            );
            // TODO: 警告用戶不能存儲其他文件，防止安全問題
        }


        // 模板全局变量
        View::share('themeAssets', 'assets/theme/' . config('hstack.theme'));

        // TODO: 注册Logo等站点信息

        // TODO 注册模板自定义页面内容
        $this->registerPath();
        $this->registerTheme();
    }

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
        //注册错误路径

    }
    protected function registerTheme()
    {
        //Todo 插件页面默认从插件加载模板 如果主题作者为插件做了模板则使用主题作者的

        $theme = config('hstack.theme');
        //如果模板作者需要额外的页面 将通过这里注册相应的路由
        if (file_exists($theme.'/theme.json')){

        }
    }
}

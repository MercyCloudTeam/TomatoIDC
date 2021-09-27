<?php

namespace App\HStack;

use App\Models\SystemSetup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SetupManager
{
    /**
     * 系统设置
     * @var array|mixed
     */
    public array $systemVariables = [];

    /**
     * 模板的设置
     * @var array|mixed
     */
    public array $viewVariables = [];

    /**
     * 模板配置的JSON转换成Array后
     * @var array|mixed
     */
    public array $themeJson;

    /**
     * 初始化
     */
    public function __construct()
    {
        $theme = config('hstack.theme');
        //初始化模板Json
        $themeJson = Cache::get( "theme-$theme-json");
        if ($themeJson == null){
            $this->initThemeJson(true);//检测是否有缓存 如果没有就获取并缓存
        }else{
            $this->themeJson = json_decode($themeJson,true);
        }

        //初始化站点设置缓存
        $systemVariables = Cache::get( 'site-setups');
        if ($systemVariables == null){
            $this->registerSystemConfig();//检测是否有缓存 如果没有就获取并缓存
        }else{
            $this->systemVariables = json_decode($systemVariables,true) ?? [];
        }

        //初始化模板设置缓存
        $viewVariables = Cache::get("theme-$theme-variables");
        if ($viewVariables == null){
            $this->registerThemeVariable();
        }else{
            $this->viewVariables = json_decode($viewVariables,true) ?? [];
        }

        //注册模板路由缓存
        if (!Cache::has("theme-$theme-routes")){
            $this->registerThemeRouteList();
        }

        $this->toView();
    }

    /**
     * 注册模板路由列表
     */
    public function registerThemeRouteList()
    {
        $theme = config('hstack.theme');
        $configs = $this->themeJson;
        if (!empty($configs) && isset($configs['router'])){
            Cache::put( "theme-$theme-routes",json_encode($configs['router']));//如果没找到配置会注册个空的
        }

    }

    /**
     * 放入缓存
     */
    public function registerSystemConfig()
    {
        $list = [];
        //从数据库中获取
        $setups = SystemSetup::where('type','system')->get();
        if (!$setups->isEmpty()){
            foreach ($setups as $item){
                foreach (config('hstack.system.setups') as $name=>$lang){
                    if ($item->name == $name){
                        $list[$item->name] = $item->value;
                    }
                }
            }
            $this->systemVariables = $list ?? [];
            Cache::put( 'site-setups',json_encode($list));
        }
    }

    /**
     * 将配置参数加载到模板可使用的变量
     */
    protected  function toView()
    {
        $list = array_merge($this->viewVariables,$this->systemVariables);
        View::share($list);
    }


    /**
     * 注册视图变量到缓存
     */
    protected function registerThemeVariable()
    {
        $configs = $this->themeJson;
        $theme = config('hstack.theme');
        $list = [];
        if (!empty($configs) && isset($configs['variable'])){
            $setups = SystemSetup::where('type','theme')->get();
            if (!$setups->isEmpty()){
                foreach ($setups as $item){
                    foreach ($configs['variable'] as $name=>$type){
                        if ($name == $item->name){
                            $list["theme_".$item->name] = $item->value;
                        }
                    }
                }
            }
            $this->viewVariables = $list ?? [];
            Cache::put( "theme-$theme-variables",json_encode($list));//如果没找到配置会注册个空的
        }

    }

    /**
     * 返回模板配置
     * @param bool $assoc
     */
    public function initThemeJson(bool $assoc = false)
    {
        $theme = config('hstack.theme');
        // 加载路径
        $file = resource_path("themes/$theme/theme.json");
        if (file_exists($file)) {
            $json = file_get_contents($file);
            Cache::put( "theme-$theme-json",$json);//如果没找到配置会注册个空的
            $this->themeJson =  json_decode($json,$assoc);
        }
    }
}

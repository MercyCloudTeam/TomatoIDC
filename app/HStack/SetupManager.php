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
    public  array $systemVariables = [];

    /**
     * 模板的设置
     * @var array|mixed
     */
    public  array $viewVariables = [];


    public function __construct()
    {
        //初始化站点设置缓存
        if (!Cache::has( 'site-setups')){
            $this->registerSystemConfig();//检测是否有缓存 如果没有就获取并缓存
        }else{
            $this->systemVariables = json_decode(Cache::get('site-setups'),true) ?? [];
        }

        //初始化模板设置缓存
        $theme = config('hstack.theme');
        if (!Cache::has("theme-$theme-variables")){
            $this->registerThemeVariable();

        }else{
            $this->viewVariables = json_decode(Cache::get("theme-$theme-variables"),true) ?? [];
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
        $configs = self::getThemeConfig(true);
        if (!empty($configs) && isset($configs['router'])){
            Cache::put( "theme-$theme-routes",json_encode($configs['router']),true);//如果没找到配置会注册个空的
        }

    }

    /**
     * 放入缓存
     */
    public  function registerSystemConfig()
    {
        $list = [];
        //从数据库中获取
        SystemSetup::where('type','system')->chunk(100, function($setups) {
            foreach ($setups as $item){
                foreach (config('hstack.system.setups') as $name=>$lang){
                    if ($item->name == $name){
                        $list[$item->name] = $item->value;
                    }
                }
            }
        });
        $this->systemVariables = $list ?? [];
        Cache::put( 'site-setups',json_encode($list),true);
    }

    /**
     * 将配置参数加载到模板可使用的变量
     */
    protected  function toView()
    {
        $list = array_merge_recursive($this->viewVariables,$this->systemVariables);
        View::share($list);
    }


    /**
     * 注册视图变量到缓存
     */
    protected function registerThemeVariable()
    {
        $configs = self::getThemeConfig();
        $list = [];
        if (!empty($configs) && isset($configs->variable)){
            $setups = SystemSetup::where('type','theme')->get();
            if (!$setups->isEmpty()){
                foreach ($setups as $item){
                    foreach ($configs->variable as $name=>$type){
                        if ("theme_$name" == $item->name){
                            $list[$item->name] = $item->value;
                        }
                    }
                }
            }
            $this->systemVariables = $list ?? [];
            Cache::put( 'site-setups',json_encode($list),true);//如果没找到配置会注册个空的
        }

    }

    /**
     * 返回模板配置
     * @param bool $assoc
     * @return mixed
     */
    public static function getThemeConfig(bool $assoc = false): mixed
    {
        $theme = config('hstack.theme');
        // 加载路径
        $file = resource_path("themes/$theme/theme.json");
        if (file_exists($file)) {
            return json_decode(file_get_contents($file),$assoc);
        }
        return false;
    }
}

<?php

namespace App\HStack;

use App\Models\SystemSetup;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SetupManager
{
    public array $list;

    public function __construct()
    {
        //初始化
        $this->list = config('hstack.system.setups');
        $this->toCache();
    }

    /**
     * 放入缓存
     */
    public function toCache()
    {
        $name = 'site-setups';
        if (!Cache::has($name)){
            //从数据库中获取
            $setups = SystemSetup::all()->chunk(5, function($setups) {
                foreach ($setups as $user) {
                    $name = $user->name;
                    echo $name;
                }
            });
            foreach ($setups as $setup){
//                $setup
                foreach ($this->list as $key=>$key){
                    if ($key == $setup->name){

                    }
                }
            }
            Cache::put($name,$this->list,3600);//默认一天
        }
    }

    public function toView()
    {
        foreach ($this->list as $k=>$v){
            View::share("setup-$k",SystemSetup::where('key',$k)->first()->value ?? null);
        }
    }

    public function reloadCache()
    {
        $name = 'site-setups';
        Cache::put($name,$this->list,3600);//默认一天
    }

}

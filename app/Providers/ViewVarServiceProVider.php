<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\SettingModel;
use Illuminate\Support\Facades\View;

class ViewVarServiceProVider extends ServiceProvider
{

    protected $defer = true;

    /**
     * 获取需要给模版传递的参数
     * 配置项名称 => 传递后变量名
     */
    protected $getSetting = [
        'setting.website.title'=>'websiteName',
        'setting.website.copyright'=>'copyright',
        'setting.website.url'=>'websiteUrl',
        'setting.website.logo'=>'websiteLogo',
    ];

    protected  function viewVariable()
    {
        foreach ($this->getSetting as $key=>$value){
            $tmp = SettingModel::where('name','=',$key)->get();
            !$tmp->isEmpty() ? $tmp = $tmp->first()->value :$tmp = null;
            View::share($value , $tmp);
        }
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->viewVariable();//向视图传递变量
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\SettingModel;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{

    /**
     * 获取需要给模版传递的参数
     * 配置项名称 => 传递后变量名
     */
    protected $getSetting = [
        'setting.website.title'=>'websiteName',
        'setting.website.copyright'=>'copyright',
        'setting.website.payment.qqpay'=>'paymentQqpay',
        'setting.website.payment.wechat'=>'paymentWechat',
        'setting.website.payment.alipay'=>'paymentAlipay',
        'setting.website.url'=>'websiteUrl',
        'setting.website.logo'=>'websiteLogo',
        'setting.website.subtitle'=>'websiteSubtitle',
        'setting.website.currency.unit'=>'currencyUnit',
        'setting.website.kf.url'=>'websiteKfUrl',
        'setting.website.logo.url'=>'websiteLogoUrl',
        'setting.website.privacy.policy'=>'privacyPolicy',
        'setting.website.user.agreements'=>'userAgreements',
    ];

    protected  function viewVariable()
    {
        if (Schema::hasTable('settings'))//当数据表存在才返回
        {
            foreach ($this->getSetting as $key=>$value){
                $tmp = SettingModel::where('name','=',$key)->get();
                !$tmp->isEmpty() ? $tmp = $tmp->first()->value :$tmp = null;
                View::share($value , $tmp);
            }
        }else{
            return null;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->viewVariable();//向视图传递变量
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

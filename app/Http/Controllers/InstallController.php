<?php

namespace App\Http\Controllers;

use App\SettingModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * 安装程序，创建管理员用户和初始化设置数据表
 * Class InstallController
 * @package App\Http\Controllers
 */
//TODO 配置.env文件

class InstallController extends Controller
{

    public function __construct()
    {
        $this->middleware('check.install.status');
    }

    /**
     * 安装页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installPage()
    {
        return view('install');
    }

    /**
     * 安装操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function installAction(Request $request)
    {
        //验证
        $this->validate($request, [
            'title' => 'string|min:3|max:100',
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:6|max:200',
        ]);

        if (!SettingModel::all()->count()) {
            $this->insertSettingSchema($request);
        }
        if (!User::all()->count()) {
            $this->insertUserSchema($request);
        }
        return redirect('/admin');
    }

    /**
     * 当用户升级版本之后如果遇到未初始化的自动初始化
     */
    public function checkSetting()
    {
        foreach ($this->settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                   SettingModel::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
    }
    /**
     * 初始化配置项名称name=>值value
     * @var array
     */
    protected $settingArray = [
        'setting.install.status' => 1,
        'setting.website.theme' => 'default',
        'setting.website.payment.alipay' => null,
        'setting.website.payment.wechat' => null,
        'setting.website.payment.qqpay' => null,
        'setting.website.payment.diy' => null,
        'setting.website.currency.unit' => 'CNY',
        'setting.website.logo.url' => null,
        'setting.website.subtitle' => "中国领先虚拟主机销售系统",
        'setting.website.logo' => null,
        'setting.website.admin.theme' => 'default',
        'setting.website.url' => 'https://mercycloud.com',
        'setting.website.title' => 'yfsama',
        'setting.website.copyright' => 'yranarf',
        'setting.website.kf.url' => '/',
        'setting.website.good.inventory' => 1,//商品库存模式
        'setting.website.aff.status' => false,
        'setting.website.user.agreements' => null,//url 用户协议
        'setting.website.privacy.policy' => null,//url 隐私协议
        'setting.website.spa.status' => false,//SPA单页模板 启用全部指向index
        'setting.website.user.email.validate' => false,//邮箱验证
        'setting.website.user.phone.validate' => false,//手机验证
        'setting.website.admin.sales.notice' => false,//管理销售通知
        'setting.website.user.email.notice' => false,//用户邮件通知
        'setting.website.version' => 'V0.1.6',

        'setting.mail.drive' => null,//邮件驱动
        'setting.website.sms.facilitator' => null,//短信服务商
        'setting.website.phone.auth' => false,//手机注册登录
        'setting.wechat.service.status' => false,//微信服务状态
        'setting.wechat.robot.status' => false,//微信机器人状态
        'setting.wechat.robot.drive' => 'Turing',
    ];

    /**
     * 创建设置项列
     * @param $request
     */
    protected function insertSettingSchema($request)
    {
        $settingTmp = $this->settingArray;
        $settingTmp['setting.website.url'] = trim($_SERVER['HTTP_HOST']);
        $settingTmp['setting.website.title'] = $request['title'];
        $settingTmp['setting.website.logo'] = $request['title'];

        foreach ($settingTmp as $key => $value) {
            SettingModel::create([
                'name' => $key,
                'value' => $value
            ]);
        }
    }

    /**
     * 添加管理员用户
     * @param $request
     */
    protected function insertUserSchema($request)
    {
        //创建用户
        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_key'=>Hash::make(mt_rand(0,9999).time().config('app.name'))
        ]);
        //管理员权限
        User::where('email', $request['email'])
            ->update(['admin_authority' => 1,'email_validate'=>1]);
    }
}

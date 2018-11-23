<?php

namespace App\Http\Controllers;

use App\SettingModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        if (SettingModel::where('name', '=', 1)->get()->isEmpty()) {
            $this->insertSettingSchema($request);
        }
        if (User::where('id', '=', 1)->get()->isEmpty()) {
            $this->insertUserSchema($request);
        }

        return redirect('/admin');
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
        'setting.website.kf.url' => null,
        'setting.website.version' => 'V0.1.0',
        'setting.mail.smtp.url' => null,
        'setting.mail.smtp.port' => null,
        'setting.mail.smtp.user' => null,
        'setting.mail.smtp.passowrd' => null,
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
        ]);
        //管理员权限
        User::where('email', $request['email'])
            ->update(['admin_authority' => 1]);
    }
}

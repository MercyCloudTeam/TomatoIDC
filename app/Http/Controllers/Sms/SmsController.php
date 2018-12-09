<?php

namespace App\Http\Controllers\Sms;

use App\SettingModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class SmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * 可选的短信验证平台
     * 名称 => 驱动文件名
     * @var array
     */
    public static $drive = [
        'SMTP邮件发送'=>'Smtp',
        '阿里云邮件推送'=>'DirectMail',
        'Mailgun-未完成'=>'Mailgun',
        'SES-未完成'=>'Ses',
        'SparkPost-未完成'=>'SparkPost',
    ];

    /**
     * 获取设置项
     * @param $settingArray array 设置名=》默认值
     * @return array
     */
    protected function getSettingFun($settingArray)
    {
        foreach ($settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
        $result = [];
        foreach ($settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;
    }

    /**
     * 获得邮件控制器class
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector class
     */
    protected function getControllerClass()
    {
        $mailDriveName = SettingModel::where('name','setting.mail.drive')->first()->value;
        $controllerName = __NAMESPACE__ . '\\' . $mailDriveName . "Controller";
        if (class_exists($controllerName)) {//检测是否有该class
            $mailDrive = new $controllerName();//动态调用控制器
            return $mailDrive;
        }
        SettingModel::where('name','setting.mail.drive')->update(['value'=>null]);//如果class不存在 直接邮件驱动清空设置
        return redirect(route('admin.setting.index'));
    }

    /**
     * 设置表单
     * @return mixed 成功返回 [描述=>数据表name]
     */
    public function configInputForm()
    {
        $mailDrive = $this->getControllerClass();
        if (method_exists($mailDrive,'configInputForm')){
            return $mailDrive->configInputForm();
        }
        return $mailDrive;
    }

    /**
     * Mail drive config save action
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function mailDriveConfigAction(Request $request)
    {
        $form = $this->configInputForm();
        if (!is_array($form)){
            return $form;
        }
        foreach ($form as $key => $value) {
            $this->validate($request, [
                $key => 'string|nullable'
            ]);
            SettingModel::where('name', $value)->update(['value' => $request[$key]]);
        }
        return back()->with('status','success');
    }

    /**
     * seed mail action
     * @param $user object App\User
     * @param $mailClassName string App\Mail Class Name
     * @param null $mailContent mail data
     * @return bool
     */
    public function sendMailFun($user,$mailClassName,$mailContent=null)
    {
        $mailClass = $this->getControllerClass();

        if (!method_exists($mailClass,'sendMail')){
            Log::debug('Email seedMail method not found',[$mailClass]);
        } else {
            $mailClass->sendMail($user,$mailClassName,$mailContent);
            return true;
        }
        Log::debug('Email seedMail error',[$mailClass]);
        return false;

    }



}

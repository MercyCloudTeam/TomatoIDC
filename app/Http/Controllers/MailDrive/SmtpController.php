<?php

namespace App\Http\Controllers\MailDrive;

use App\Http\Controllers\ThemeController;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Mail\TransportManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

/**
 * SMTP邮件发送
 */

class SmtpController extends UserMailController
{
    protected $settingArray = [
        'setting.mail.smtp.host' => null,
        'setting.mail.smtp.port' => null,
        'setting.mail.smtp.user' => null,
        'setting.mail.smtp.passowrd' => null,
        'setting.mail.smtp.encryption' => 'ssl',
    ];

    protected function getSetting()
    {
        return parent::getSettingFun($this->settingArray);
    }

    /**
     * Setting send mail config
     */
    protected function setConfig()
    {
        parent::setConfigFun();
        $setting = $this->getSetting();
        config(['mail.from.address'=>$setting['setting.mail.smtp.user']]);
        config(['mail.username'=>$setting['setting.mail.smtp.user']]);
        config(['mail.password'=>$setting['setting.mail.smtp.passowrd']]);
        config(['mail.host'=>$setting['setting.mail.smtp.host']]);
        config(['mail.encryption'=>$setting['setting.mail.smtp.encryption']]);
        config(['mail.port'=>$setting['setting.mail.smtp.port']]);
    }

    /**
     * send mail action
     * @param $user object App\User
     * @param $mailClassName string App\Mail\ClassName
     * @param null $mailContent mail date
     * @return bool
     */
    public function sendMail($user, $mailClassName,$mailContent=null)
    {
        $this->setConfig();
        app('swift.transport')->setDefaultDriver('smtp');           // 修改默认的 driver
        app('mailer')->setSwiftMailer(new \Swift_Mailer(app('swift.transport')->driver()));
        app('mailer')->alwaysFrom(\config('mail.from.address'),\config('mail.from.name'));
//        dd(\app('mailer'));
        $controllerName = parent::getMailClass($mailClassName);
        if (!empty($controllerName)){
            Mail::to($user)->send(new $controllerName($mailContent));
            return true;
        }
        return false;
    }

    /**
     * config input form
     * @return array|mixed
     */
    public function configInputForm()
    {
        $this->getSetting();
        return [
            'SMTP服务器地址' =>'setting.mail.smtp.host',
            'SMTP服务器端口' =>'setting.mail.smtp.port',
            'SMTP账户' =>'setting.mail.smtp.user',
            'SMTP密码' =>'setting.mail.smtp.passowrd',
            '加密方式' =>'setting.mail.smtp.encryption',
        ];
    }


}
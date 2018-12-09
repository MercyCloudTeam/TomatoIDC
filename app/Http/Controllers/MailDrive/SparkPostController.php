<?php

namespace App\Http\Controllers\MailDrive;

/**
 * SMTP邮件发送
 */


class SparkPostController extends UserMailController
{
    protected $settingArray = [
        'setting.mail.mailgun.secret' => null,
        'setting.mail.mailgun.domain' => null,
    ];

    protected function getSetting()
    {
        return parent::getSettingFun($this->settingArray);
    }

    public function configInputForm()
    {
        $this->getSetting();
        return [
            'Domain' =>'setting.mail.mailgun.domain',
            'Secret' =>'setting.mail.mailgun.secret',
        ];
    }
}
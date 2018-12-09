<?php

namespace App\Http\Controllers\MailDrive;

/**
 * SMTP邮件发送
 */


class SesController extends UserMailController
{
    protected $settingArray = [
        'setting.mail.ses.key' => null,
        'setting.mail.ses.secret' => null,
        'setting.mail.ses.region' => 'us-east-1',
    ];

    protected function getSetting()
    {
        return parent::getSettingFun($this->settingArray);
    }

    public function configInputForm()
    {
        $this->getSetting();
        return [
            'secret' =>'setting.mail.ses.secret',
            'key' =>'setting.mail.ses.key',
            'region' =>'setting.mail.ses.region',
        ];
    }
}
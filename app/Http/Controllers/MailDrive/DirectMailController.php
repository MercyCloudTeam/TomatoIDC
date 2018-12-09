<?php

namespace App\Http\Controllers\MailDrive;

/**
 * SMTP邮件发送
 */

class DirectMailController extends UserMailController
{
    protected $settingArray = [
        'setting.mail.directmail.key' => null,
        'setting.mail.directmail.address.type' => 1,
        'setting.mail.directmail.from.alias' => null,
        'setting.mail.directmail.click.trace' => 0,
        'setting.mail.directmail.version' => '2015-11-23',
        'setting.mail.directmail.region.id' => null,
    ];

    protected function getSetting()
    {
        return parent::getSettingFun($this->settingArray);
    }

    public function configInputForm()
    {
        $this->getSetting();
        return [
            'key'=>'setting.mail.directmail.key' ,
            'address_type'=>'setting.mail.directmail.address.type',
            'from_alias'=>'setting.mail.directmail.from.alias',
            'click_trace'=>'setting.mail.directmail.click.trace' ,
            'version'=>'setting.mail.directmail.version' ,
            'region_id'=>'setting.mail.directmail.region.id' ,
        ];
    }


}
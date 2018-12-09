<?php

namespace App\Mail;

use App\Http\Controllers\ThemeController;
use App\SettingModel;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

class UserEmailValidate extends Mailable
{
    use Queueable, SerializesModels;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(ThemeController::backThemePath('emails.user.email_validate'))->with([
            'url'=>$this->url
        ])->subject('验证你的电子邮件地址');
    }
}

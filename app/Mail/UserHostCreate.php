<?php

namespace App\Mail;

use App\HostModel;
use App\Http\Controllers\ThemeController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserHostCreate extends Mailable
{
    use Queueable, SerializesModels;

    public $host;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(HostModel $host)
    {
        $this->host = $host;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(ThemeController::backThemePath('emails.hosts.create'))->with([
            'goodTitle'=>$this->host->order->good->title,
            'hostName'=>$this->host->host_name,
            'hostPass'=>$this->host->host_pass,
            'hostPanel'=>$this->host->host_panel,
            'hostUrl'=>$this->host->host_url,
            'hostIp'=>$this->host->host_ip,
            'deadline'=>$this->host->deadline,
            'orderPrice'=>$this->host->order->price,
        ])->subject('你的主机创建成功');
    }
}

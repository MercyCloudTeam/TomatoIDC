<?php

namespace App\Mail;

use App\Http\Controllers\ThemeController;
use App\OrderModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOrderPay extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(OrderModel $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(ThemeController::backThemePath('emails.orders.pay_success'))->with([
            'orderNo'=>$this->order->no,
            'goodTitle'=>$this->order->good->title,
            'orderPrice'=>$this->order->price,
        ])->subject('你的订单支付成功');
    }
}

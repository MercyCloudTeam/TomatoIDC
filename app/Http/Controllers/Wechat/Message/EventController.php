<?php

namespace App\Http\Controllers\Wechat\Message;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;

class EventController implements EventHandlerInterface
{
    public function handle($payload = null)
    {
        if (!empty($payload['MsgType'])) {
            switch ($payload['Event']) {
                case "subscribe":
                    return new Text('欢迎关注');
                    break;
            }
        }
//        $text = new Text('');
//        return $text;
    }
}
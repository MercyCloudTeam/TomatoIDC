<?php

namespace App\Http\Controllers\Wechat\Message;

use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;

class ImageHandle implements EventHandlerInterface
{
    public function handle($payload = null)
    {
        //忘了可以有人发黄图，然后复读，了
//        if (!empty($payload['MsgType']) && !empty($payload['MediaId'])) {
//            return new Image($payload['MediaId']);
//        }
        if (!empty($payload['MsgType'])) {
        return new Text('看不懂.jpg');
        }
    }
}
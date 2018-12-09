<?php

namespace App\Http\Controllers\Wechat\Message;

use App\Http\Controllers\Wechat\WechatController;

class MessageController extends WechatController
{
    public function handleMessage($message)
    {
            switch ($message['MsgType']) {
//                case 'event':
//                    $message = new EventController();
//                    return $message->handleMessage($message);
//                    break;
                case 'text':
                    $message = new TextHandle();
                    return $message->handleMessage($message);
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                    break;
                default:
                    return '收到其它消息';
                    break;
            }
    }
}
<?php

namespace App\Http\Controllers\Wechat\Message\Robot;

//TODO 接入图灵机器人

use App\SettingModel;
use GuzzleHttp\Client;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;

class TuringController implements EventHandlerInterface
{

    protected $api= "http://openapi.tuling123.com/openapi/api/v2";

    public function handle($payload = null)
    {
        if (empty($this->checkSettingStatus())){
            return null;
        }
        return null;
        $replyMessage = $this->getReply($message);

        switch ($message['Event']){
            case "subscribe":
                return  "欢迎订阅";
                break;
            default:
                return '嘿嘿嘿';
                break;
        }
    }

    protected function getReply($message)
    {
        switch ($message['MsgType']){
            case 'text':
                $reqType = 0;
                $perception = [
                  'inputText'=>['text'=>$message['Content']]
                ];
                break;
            case 'image':
                $reqType = 1;
                $perception = [
                    'inputText'=>['text'=>$message['PicUrl']]
                ];
                break;
//            case 'voice': //TODO 语音
//                $reqType = 2;
//                $perception = [
//                    'inputText'=>['text'=>$message['Content']]
//                ];
//                break;
            default :
                return '';
        }
        $set = $this->checkSettingStatus();
        $client = new Client();
        $response = $client->request('POST', 'http://openapi.tuling123.com/openapi/api/v2', [
            "reqType"=>$reqType,
            "perception"=>$perception,
            "userInfo"=>[
                'userId'=>$message['FormUserName'],
                'apiKey'=>$set['setting.wechat.robot.turing.api.key']
            ]
        ]);
//        dd($response);
    }

    protected function checkSettingStatus()
    {
        $set = SettingModel::where('name','setting.wechat.robot.drive')->get();
        if ($set->isEmpty() && $set->first()->value != 1){
            return false;
        }
        $settingArr=[
            'setting.wechat.robot.turing.api.key'=>null,
            'setting.wechat.robot.turing.key'=>null
        ];
        foreach ($settingArr as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
        $result = [];
        foreach ($settingArr as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;

    }
}
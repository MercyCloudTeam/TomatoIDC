<?php

namespace App\Http\Controllers\Wechat\Message\Robot;

//TODO 接入图灵机器人

use App\SettingModel;
use GuzzleHttp\Client;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;

class TuringController implements EventHandlerInterface
{

    protected $api = "http://openapi.tuling123.com/openapi/api/v2";

    public function handle($payload = null)
    {
        Log::debug('wechat turing message',[$payload]);
//        dd($payload[0]);
//        if (empty($payload)){
//            Log::debug('wechat turing message',[$payload]);
//            return new Text('蛤');
//        }
        $reply =$this->getReply($payload);
        Log::debug('wechat turing message',[$reply]);
        return new Text($reply);
    }

    public function test()
    {
        dd( $this->mock() );
    }

    protected function mock()
    {
        $message['MsgType']      = "text";
        $message['FormUserName'] = "1234364";
        $message['Content']      = "你是谁";

//        $this->getReply($message);
        return $this->getReply($message);
    }

    public function getReply($message)
    {
        //dev
//        Log::debug("turing message ",[$message]);
        //        dd(123);
        switch ($message['MsgType']) {
            case 'text':
                $reqType    = 0;
                $perception = [
                    'inputText'  => ['text' => $message['Content']],
//                    'inputImage' => ["url" => "imageUrl"],
//                    'inputMedia'=>['url'=>null]
                ];
                break;
            case 'image':
                $reqType    = 1;
                $perception = [
//                    'inputText'  => ['text' => null],
                    'inputImage' => ["url" => $message['PicUrl']],
//                    'inputMedia'=>['url'=>null]
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
        //        dd(123);
        $set    = $this->checkSettingStatus();
        $client = new Client(['base_uri' => 'http://openapi.tuling123.com', 'timeout' => 5.0,]);
//        $tmepArr =;
        $response = $client->post('http://openapi.tuling123.com/openapi/api/v2', [
            'json' => [
                "reqType"    => $reqType,
                "perception" => $perception,
                "userInfo"   => [
                    'userId' => $message['FormUserName'],
                    'apiKey' => $set['setting.wechat.robot.turing.api.key']
                ],
//                "location"   => [
//                    'city' => '北京'
//                ]
            ]
        ]);
        //        dd($client);
        $body = $response->getBody();
        Log::debug('Turing Robot Log',[(string)$body]);
        $result = json_decode((string)$body);
        if (!empty($result->results)){
            foreach ($result->results as $item){
//                dd($item);
                switch ($item->resultType){
                    case "text";
                    case "url":
//                        dd($item->values->text);
                        return $item->values->text;
                        break;
                    default:
                        Log::debug('Turing Robot Log',[$body]);
                }

            }
        }
        Log::debug('Turing Robot Log',[$body]);
    }


    protected function checkSettingStatus()
    {
        $set = SettingModel::where('name', 'setting.wechat.robot.drive')->get();
        if ($set->isEmpty() && $set->first()->value != 1) {
            return false;
        }
        $settingArr = [
            'setting.wechat.robot.turing.api.key' => null,
            'setting.wechat.robot.turing.key'     => null
        ];
        foreach ($settingArr as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create(
                    [
                        'name'  => $key,
                        'value' => $value
                    ]
                );
            }
        }
        $result = [];
        foreach ($settingArr as $key => $value) {
            $setTemp      = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;

    }
}
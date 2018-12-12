<?php

namespace App\Http\Controllers\Wechat\Message;

use App\Http\Controllers\Wechat\Message\Robot\TuringController;
use App\User;
use Carbon\Carbon;
use EasyWeChat\Kernel\Contracts\EventHandlerInterface;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use Illuminate\Support\Facades\DB;

class TextHandle implements EventHandlerInterface
{
    public function handle($payload = null)
    {
        if (!empty($payload['MsgType'])) {
            $this->createDate($payload);
            switch ($payload['Content']) {
                case 'help';
                case "帮助":
                    return new Text($this->helpMessage);
                    break;
                case "账户验证";
                case '账户绑定';
                case '绑定':
                    //                    if ($payload[''])
                    $items = [
                        new NewsItem(
                            [
                                'title'       => '绑定账户',
                                'description' => '绑定账户享受更多服务',
                                'url'         => route('wechat.oauth'),
                                'image'       => url('/assets/themes/argon/img/computer-1149148.jpg'),
                            ]
                        ),
                    ];
                    $news  = new News($items);
                    return $news;
                    break;
                case "账户余额";
                case "用户余额";
                case "余额":
                    $user = User::where('wechat_openid', $payload['FromUserName'])->get();
                    if (!$user->isEmpty()) {
                        return new Text("当前账户余额：" . $user->first()->account);
                    }
                    else {
                        return new Text("未绑定账户，请回复“绑定”进行账户绑定");
                    }
                    break;
//                default:
//                    return new Text(new TuringController())
//                    return new Text('回复"帮助"获取可以使用的功能哟');
//                                        return new Text("人类的本质就是复读机：" . $payload['Content']);
//                    break;
            }
        }
//        return new Text('蛤');
//        if (empty($payload)){

//        }
//        $text = new Text('蛤');
//        return new Text(null);
//        return $text;
        //        return '听不懂';
    }

    protected function createDate($message)
    {
        DB::table('wechat_message')->insert(
            [
                'openid' => $message['FromUserName'],
                'message'=> $message['Content'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
            ]
        )
        ;
    }

    protected $helpMessage
        = "回复\"绑定\"即可绑定账户" . PHP_EOL .
          "回复\"余额\"即可查询账户余额" . PHP_EOL .
          "更多功能还在开发中敬请期待";
}
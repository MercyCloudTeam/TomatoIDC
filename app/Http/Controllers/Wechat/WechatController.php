<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Wechat\Message\EventController;
use App\Http\Controllers\Wechat\Message\ImageHandle;
use App\Http\Controllers\Wechat\Message\Robot\TuringController;
use App\Http\Controllers\Wechat\Message\TextHandle;
use App\SettingModel;
use App\User;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use EasyWeChat\Kernel\Messages\Message;

//TODO 后续微信方面开发 (挖坑)

class WechatController extends Controller
{
    public function __construct()
    {
        if (!$this->checkWechatServiceStatus()){
            die(json_encode(['status'=>'failure']));
        }
    }

    public function wechatApi(Request $request)
    {
        //Dev log
//        Log::info('request arrived.',[$request]);

        $config = $this->getOfficialAccountConfigArr();

        $app = Factory::officialAccount($config);
                $app->server->push(function ($message) {
                    return "蛤";
                });
        $app->server->push(TextHandle::class,Message::TEXT);
        $app->server->push(ImageHandle::class,Message::IMAGE);
        $app->server->push(EventController::class,Message::EVENT);
        $app->server->push(TuringController::class,Message::TEXT|Message::IMAGE);

        $response = $app->server->serve();

        return $response;
    }

    protected function getOfficialAccountConfigArr()
    {
        $officialAccount = new OfficialAccountController();
        return $officialAccount->getConfigArr();
    }

    public function oauthApi()
    {
        $config = $this->getOfficialAccountConfigArr();
        $config['oauth'] = [
            'scopes' => ['snsapi_userinfo'],
            'callback' => '/wechat/oauth/user/callback',
        ];
        $app = Factory::officialAccount($config);
        $response = $app->oauth->scopes(['snsapi_userinfo'])->redirect();
        return $response;

    }

    public function oauthCallbackApi()
    {
        if (Auth::user() && empty(Auth::user()->wechat_openid)) {
            $config = $this->getOfficialAccountConfigArr();
            $app = Factory::officialAccount($config);
            $oauth = $app->oauth;
            $user = $oauth->user();
            if (User::where(['wechat_openid'=>$user->getId()])->get()->isEmpty()) {
                User::where('id', Auth::id())->update(['wechat_openid' => $user->getId()]);

                try {
                    $app->customer_service->message(new Text('绑定成功'))->to($user->getId())->send();
                } catch (\Exception $e){
                    Log::error('Wechat Office Account Send Mail Error',[$e]);
                }

                return redirect('/home')->with('status', 'success');
            }
            return redirect('/home')->with('status', 'failure');
        }
        return redirect('/home');
    }

    protected function setConfig()
    {

    }

    /**
     * Wechat Setting Action
     * @param Request $request
     * @return array|bool|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function wechatConfigAction(Request $request)
    {
        $form = $this->configInputForm();
        if (!is_array($form)){
            return $form;
        }
        foreach ($form as $classForms) {
            foreach ($classForms as $classForm) {
                foreach ($classForm as $key => $value) {
                    $this->validate($request, [
                        $key => 'string|nullable'
                    ]);
                    SettingModel::where('name', $value)->update(['value' => $request[$key]]);
                }
            }
        }
        return back()->with('status','success');
    }

    /**
     * Get All controller configinputform
     * @return array|bool
     */
    public function configInputForm()
    {
        $dir = scandir(app_path('Http/Controllers/Wechat'));
        $className = [];
        foreach ($dir as $item){
            if ($item == '.' or $item == '..' or $item == "WechatController.php" or $item == 'Message'){
                continue;
            }
            $value = str_replace('.php','',$item);
            array_push($className,$value);
        }
        if (!empty($className)){
            $configInputFromArr = [];
            foreach ($className as $name){
                $name = __NAMESPACE__ . '\\' . $name;
                if (class_exists($name,true)){
                    $class = new $name;
                    if (method_exists($class,'configInputForm')){
                        $arr = $class->configInputForm();
                        array_push($configInputFromArr,$arr);
                    }
                }
            }
        }
//        dd($configInputFromArr);
        if (!empty($configInputFromArr)){
            return $configInputFromArr;
        }
        return false;
    }

    /**
     * check setting wechat servies status
     * @return bool
     */
    protected function checkWechatServiceStatus()
    {
        $setting = SettingModel::where('name','setting.wechat.service.status')->get();
//        dd($setting->first()->value);
        if ($setting->isEmpty()){
            return false;
        }
        return (bool) $setting->first()->value;
    }
    /**
     * 获取设置项
     * @param $settingArray array 设置名=》默认值
     * @return array
     */
    protected function getSettingFun($settingArray)
    {
        foreach ($settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->get();
            if ($setTemp->isEmpty()) {
                SettingModel::create([
                    'name' => $key,
                    'value' => $value
                ]);
            }
        }
        $result = [];
        foreach ($settingArray as $key => $value) {
            $setTemp = SettingModel::where('name', $key)->first();
            $result[$key] = $setTemp['value'];
        }
        return $result;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Payment\PayController;
use App\ServerModel;
use App\User;
use App\UserRechargeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserRechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户充值支付操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userRechargePayAction(Request $request)
    {
        $this->validate($request,[
            'money'=>'required|numeric',
            'payment' => 'in:wechat,alipay,diy,qqpay|string|required',
        ]);

        $money =round(abs($request->money),2);
        $order = $this->makeUserRecharge(Auth::id(),$money,'user_recharge');

        $pay = new PayController;
        $payPage = $pay->makePay($request->payment,$order);
        return $pay->payPage($payPage);

//        switch ($payPage['type']) { //判断插件返回值
//            case "qrcode": //二维码
////                    if (PayController::isMobile()){
////                        return redirect($payPage['url']);
////                        break;
////                    }
//                return QrCode::size(200)->color(94, 114, 228)->generate($payPage['url']);
////                return view(ThemeController::backThemePath('pay', 'home.goods'), compact('order', 'payPage'));
//                break;
//            case "redirect": //跳转
////                    dd($payPage['url']);
//                return redirect($payPage['url']);
//                break;
//        }
    }

    /**
     * 检查支付状态
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userRechargeCheckStatusAction(Request $request)
    {
        $this->validate($request, [
            'no' => 'exists:user_recharge,no|required'
        ]);
        return $this->userRechargeCheckStatusFun($request['no']);
    }


    /**
     * 检测支付状态
     * @param $no
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userRechargeCheckStatusFun($no)
    {
        $order = UserRechargeModel::where('no', $no)->first();//获取订单

        $status = 3 ;
//        var_dump( $status == 2);//true
//        var_dump($order->status); //(int) 2
//        var_dump(2); //(int) 2
//        var_dump(2 == $order->status); //true
//        求下面两个是返回什么
//        var_dump( $status == $order->status); //???
//        var_dump($order->status　== $status); //???

        if ($status == $order->status){
            $user_id =$order->user_id;
            $user = User::where('id',$user_id)->first();
//            dd(round(abs($user->account+= $order->money)));
            User::where('id',$user_id)->update(['account'=>round(abs($user->account+= $order->money),2)]);//充值操作
            UserRechargeModel::where('no',$no)->update(['status'=>2]);
        }

        if ($order->status == 1) {//订单未支付的时候返回列表
            return redirect(route('home')); //默认返回
        }
        return redirect(route('home')); //默认返回
    }

    /**
     * 创建用户充值订单
     * @param $user_id
     * @param $money
     * @param null $type
     * @return mixed
     */
    protected function makeUserRecharge($user_id,$money,$type=null)
    {
        $no = date('y') . mt_rand(10, 99) . substr(time(), 6) . mt_rand(100, 999);
//        dd(abs(round($money,2)));
        $userRecharge = UserRechargeModel::create([
            'no'=>$no,
            'user_id'=>$user_id,
            'type'=>$type,
            'money'=>abs(round($money,2))
        ]);
        return $userRecharge;
    }
}

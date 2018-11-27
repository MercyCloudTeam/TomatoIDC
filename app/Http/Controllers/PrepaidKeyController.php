<?php

namespace App\Http\Controllers;

use App\PrepaidKeyModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

//TODO 卡密以后使用NOSQL

class PrepaidKeyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 生成一个key
     * @return string Key
     */
    protected function makeKey()
    {
        $rand = md5(time().date('ymd').mt_rand(0,9999).config('app.name'));
        return $key = strtoupper(md5($rand.mt_rand(0,9999)));
    }

    /**
     * 添加Key操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addKeyAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request,[
           'num'=>'integer|required',
           'account' =>'numeric|required',
           'deadline' =>'integer|nullable',
        ]);

        !empty($request->deadline) ? $deadline = Carbon::now()->addDay($request->deadline)  : $deadline = Carbon::now()->addDay(9999);
        $keyList = [];
        for ($i = 1 ;$i<=abs($request['num']);$i++) {
            $tempKey = PrepaidKeyModel::create([
                'key' => $this->makeKey(),
                'account' => round(abs($request['account']),2),
                'deadline'=>$deadline
            ]);
            array_push($keyList,$tempKey->key);
        }
        return redirect(route('admin.prepaid.key.show'))->with('key',$keyList);
    }

    /**
     * 充值卡密操作
     */
    public function rechargePrepaidKeyAction(Request $request)
    {
        $this->validate($request,[
           'key'=>'required|string|exists:prepaid_keys,key'
        ]);

        $key = PrepaidKeyModel::where('key',$request->key)->first();
        $new = Carbon::now();
        if ($key->status == 1 && $new->lt($key->deadline)){ // 充值成功输出
            User::where('id',Auth::id())->update(['account'=>round(abs(Auth::user()->account+=$key->account),2)]);
            PrepaidKeyModel::where('key',$key->key)->update(['status'=>2,'user_id'=>Auth::id()]);
            return redirect(route('user.recharge'))->with('status','success');
        }
        return redirect(route('user.recharge'))->with('status','failure');
    }
}

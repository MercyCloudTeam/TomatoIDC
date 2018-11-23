<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
     * 用户更改个人信息操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function userEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'password' => 'nullable|string|min:6',
            'name' => 'nullable|string|max:255',
            'qq' => 'digits_between:5,11|integer|nullable',
            'phone' => 'digits_between:6,15|integer|nullable',
            'account' => 'integer|nullable',
            'signature' => 'min:3|max:999|string|nullable',
            'id' => 'exists:users,id|required'
        ]);

        $user = User::where('id', $request['id'])->first();
        if ($user->name != $request['name']) { //验证是否重名
            $this->validate($request, [
                'name' => 'unique:users,name'
            ]);
        }
        //TODO 提高性能
        if (!empty($request['password'])) {
            User::where('id', Auth::id())
                ->update(['password' => Hash::make($request['password'])]);
            Auth::logout();
        }
        $user->name == $request['name'] ?: User::where('id', $request['id'])->update(['name' => $request['name']]);
        $user->qq == $request['qq'] ?: User::where('id', $request['id'])->update(['qq' => $request['qq']]);
        $user->phone == $request['phone'] ?: User::where('id', $request['id'])->update(['phone' => $request['phone']]);
        $user->signature == $request['signature'] ?: User::where('id', $request['id'])->update(['signature' => $request['signature']]);
        $user->account == $request['account'] ?: User::where('id', $request['id'])->update(['account' => $request['account']]);

        return back();
    }
}

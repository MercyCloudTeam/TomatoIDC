<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiyPageController extends Controller
{
    public function indexPage($hash)
    {
        $hash = htmlspecialchars(trim($hash));
        if (DB::table('diy_page')->where([['hash', $hash], ['status', 1]])->exists()) {
            $page = DB::table('diy_page')->where([['hash', $hash], ['status', 1]])->first();
            return view(ThemeController::backThemePath('diy_page'), compact('page'));
        }
        else {
            return redirect('/');
        }
    }

    /**
     * 自定义页面添加操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function diyPageAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
            'hash'    => 'min:2|unique:diy_page',
            'content' => 'min:3|max:65535'
        ]
        );
        DB::table('diy_page')->insert(
            ['hash' => $request['hash'], 'content' => $request['content']]
        )
        ;
        return redirect(route('admin.diy.page.show'));
    }

    /**
     * 页面编辑
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function diyPageEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
            'hash'    => 'min:2',
            'content' => 'min:3|max:65535'
        ]
        );
        DB::table('diy_page')->where('hash', $request['hash'])->update(
            ['hash' => $request['hash'], 'content' => $request['content']]
        )
        ;
        return redirect(route('admin.diy.page.show'));
    }

    /**
     * 软删除页面
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function diyPageDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
//        dd($request);
        $this->validate($request, [
            'hash' => 'exists:diy_page,hash|required'
        ]);
        DB::table('diy_page')->where('hash', $request['hash'])->update(['status' => 0]);
        return redirect(route('admin.diy.page.show'));
    }
}

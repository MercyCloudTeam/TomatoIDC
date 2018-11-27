<?php

namespace App\Http\Controllers;

use App\GoodCategoriesModel;
use App\GoodConfigureModel;
use App\GoodModel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodController extends Controller
{
    /**
     * 商品类型
     * @var array
     */
    public static $goodsType = [
        'shadowsocks' => '影梭',
        'virtual_host' => '虚拟主机',
        'virtual_private_server' => 'VPS服务器',
    ];

    /**
     * 创建分组
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodCategoriesAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'subtitle' => 'string|min:3|max:200|nullable',
            'content' => 'string|min:3|nullable',
            'display' => 'boolean',
            'level' => 'integer'
        ]);
        GoodCategoriesModel::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'display' => $request['display'],
            'level' => $request['level'],
            'content' => $request['content']
        ]);
        return redirect(route('admin.good.show'));
    }

    /**
     * 编辑分组操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodCategoriesEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'subtitle' => 'string|min:3|max:200|nullable',
            'content' => 'string|min:3|nullable',
            'display' => 'boolean',
            'level' => 'integer',
            'id' => 'exists:goods_categories,id|required'
        ]);
        GoodCategoriesModel::where('id', $request['id'])->update([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'display' => $request['display'],
            'level' => $request['level'],
            'content' => $request['content']
        ]);
        return redirect(route('admin.good.show'));
    }

    /**
     * 软删除分组操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodCategoriesDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'id' => 'exists:goods_categories,id|required'
        ]);
        GoodCategoriesModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.good.show'));
    }

    /**
     * 商品添加操作
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'price' => 'numeric',
            'subtitle' => 'string|min:3|max:200|nullable',
            'description' => 'string|min:3|nullable',
            'display' => 'boolean',
            'level' => 'integer',
            'configure' => 'nullable|exists:goods_configure,id',
            'server' => 'nullable|exists:servers,id|nullable',
            'categories' => 'nullable|exists:goods_categories,id'
        ]);

        GoodModel::create([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'price' => round(abs($request['price']),2),
            'description' => $request['description'],
            'level' => $request['level'],
            'display' => $request['display'],
            'configure_id' => $request['configure'],
            'categories_id' => $request['categories'],
            'server_id' => $request['server'],
        ]);

        return redirect(route('admin.good.show'));
    }

    /**
     * 添加商品配置操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodConfigureAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'qps' => 'string|nullable',
            'php_version' => 'string|nullable',
            'mysql_version' => 'string|nullable',
            'db_quota' => 'string|nullable',
            'domain' => 'string|nullable',
            'max_connect' => 'string|nullable',
            'max_worker' => 'string|nullable',
            'doc_root' => 'string|nullable',
            'web_quota' => 'string|nullable',
            'speed_limit' => 'string|nullable',
            'log_handle' => 'string|nullable',
            'type' => 'string|nullable',
            'module' => 'string|nullable',
            'subdir' => 'string|nullable',
            'subdir_flag' => 'string|nullable',
            'db_type' => 'string|nullable',
            'flow_limit' => 'string|nullable',
            'max_subdir' => 'string|nullable',
            'time' => 'string|nullable',
            'ftp' => 'string|nullable',
        ]);

        GoodConfigureModel::create([
            'title' => $request['title'],
            'qps' => $request['qps'],
            'php_version' => $request['php_version'],
            'mysql_version' => $request['mysql_version'],
            'db_quota' => $request['db_quota'],
            'domain' => $request['domain'],
            'max_connect' => $request['max_connect'],
            'max_worker' => $request['max_worker'],
            'module' => $request['module'],
            'doc_root' => $request['doc_root'],
            'web_quota' => $request['web_quota'],
            'speed_limit' => $request['speed_limit'],
            'log_handle' => $request['log_handle'],
            'subdir' => $request['subdir'],
            'type' => $request['type'],
            'subdir_flag' => $request['subdir_flag'],
            'db_type' => $request['db_type'],
            'flow_limit' => $request['flow_limit'],
            'max_subdir' => $request['max_subdir'],
            'time' => $request['time'],
            'ftp' => $request['ftp']
        ]);

        return redirect(route('admin.good.show'));
    }

    /**
     * 添加商品配置操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodConfigureEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'qps' => 'string|nullable',
            'php_version' => 'string|nullable',
            'mysql_version' => 'string|nullable',
            'db_quota' => 'string|nullable',
            'domain' => 'string|nullable',
            'max_connect' => 'string|nullable',
            'max_worker' => 'string|nullable',
            'doc_root' => 'string|nullable',
            'web_quota' => 'string|nullable',
            'speed_limit' => 'string|nullable',
            'log_handle' => 'string|nullable',
            'subdir' => 'string|nullable',
            'subdir_flag' => 'string|nullable',
            'db_type' => 'string|nullable',
            'flow_limit' => 'string|nullable',
            'max_subdir' => 'string|nullable',
            'time' => 'string|nullable',
            'ftp' => 'string|nullable',
            'type' => 'string|nullable',
            'module' => 'string|nullable',
            'id' => 'exists:goods_configure,id|required'
        ]);

        GoodConfigureModel::where([
            ['status', '!=', '0'],
            ['id', $request['id']]
        ])->update([
            'title' => $request['title'],
            'qps' => $request['qps'],
            'php_version' => $request['php_version'],
            'mysql_version' => $request['mysql_version'],
            'db_quota' => $request['db_quota'],
            'domain' => $request['domain'],
            'max_connect' => $request['max_connect'],
            'max_worker' => $request['max_worker'],
            'doc_root' => $request['doc_root'],
            'web_quota' => $request['web_quota'],
            'speed_limit' => $request['speed_limit'],
            'log_handle' => $request['log_handle'],
            'type' => $request['type'],
            'module' => $request['module'],
            'subdir' => $request['subdir'],
            'subdir_flag' => $request['subdir_flag'],
            'db_type' => $request['db_type'],
            'flow_limit' => $request['flow_limit'],
            'max_subdir' => $request['max_subdir'],
            'time' => $request['time'],
            'ftp' => $request['ftp']
        ]);

        return redirect(route('admin.good.show'));
    }

    public function goodConfigureDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'id' => 'exists:goods,id|required'
        ]);
        GoodConfigureModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.good.show'));
    }

    /**
     * 商品编辑操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodEditAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'title' => 'string|min:3|max:200',
            'price' => 'numeric',
            'subtitle' => 'string|min:3|max:200|nullable',
            'description' => 'string|min:3|nullable',
            'display' => 'boolean',
            'level' => 'integer',
            'configure' => 'nullable|exists:goods_configure,id',
            'server' => 'nullable|exists:servers,id|nullable',
            'categories' => 'nullable|exists:goods_categories,id',
            'id' => 'exists:goods,id|required'
        ]);

        GoodModel::where([
            ['id', $request['id']],
            ['status', '!=', '0']
        ])->update([
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'price' => round(abs($request['price']),2),
            'description' => $request['description'],
            'level' => $request['level'],
            'display' => $request['display'],
            'configure_id' => $request['configure'],
            'categories_id' => $request['categories'],
            'server_id' => $request['server'],
        ]);

        return redirect(route('admin.good.show'));
    }

    /**
     * 商品软删除操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate($request, [
            'id' => 'exists:goods,id|required'
        ]);
        GoodModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.good.show'));
    }
}

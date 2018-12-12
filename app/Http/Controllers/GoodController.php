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
    public static $goodsType
        = [
            'shadowsocks'            => '影梭',
            'virtual_host'           => '虚拟主机',
            'virtual_private_server' => 'VPS服务器',
        ];


    protected $virtual_host_configure_form
        = [
            'php_version'     => 'PHP版本',
            'mysql_version'   => 'Mysql版本',
            'db_quota'        => '数据库大小',
            'web_quota'       => 'Web空间大小',
            'module'          => '模块',
            'speed_limit'     => '速度限制',
            'flow_limit'      => '流量限制',
            'max_connect'     => '最大连接数',
            'domain'          => '域名',
            'doc_root'        => '主机主目录',
            'log_handle'      => '是否开启日记分析',
            'subdir'          => '默认绑定目录',
            'max_worker'      => '最多工作者',
            'subdir_flag'     => '是否允许绑定子目录',
            'max_subdir'      => '最多子目录数',
            'ftp'             => '开启FTP',
            'template'        => '面板页面主题',
            'config_template' => '面板配置模板',
            'free_domain'     => '免费二级域名',
            'language'        => '默认语言',
            'useregns'        => '是否为域使用注册的域名服务器',
            'hasuseregns'     => '遗留参数',
            'forcedns'        => '是否使用新帐户的信息覆盖现有DNS区域',
            'reseller'        => '是否是分销商',
            'maxsql'          => '最大开通数据库数量',
            'cgi'             => 'CGI',
            'maxftp'          => '最大开通FTP数量',
            'maxpop'          => '帐户的最大电子邮件帐户数',
            'maxpark'         => '帐户的最大停放域数（别名）',
            'maxaddon'        => '帐户的最大插件域数。',
            'customip'        => '手动指定ip',
        ];

    public function getConfigureFromInput($type)
    {
        switch ($type) {
            case "virtual_host":
                return $this->virtual_host_configure_form;
                break;
            case "virtual_private_server":
                break;
        }
    }

    /**
     * 创建分组
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodCategoriesAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'title'    => 'string|min:3|max:200',
                        'subtitle' => 'string|min:3|max:200|nullable',
                        'content'  => 'string|min:3|nullable',
                        'display'  => 'boolean',
                        'level'    => 'integer'
                    ]
        );
        GoodCategoriesModel::create(
            [
                'title'    => $request['title'],
                'subtitle' => $request['subtitle'],
                'display'  => $request['display'],
                'level'    => $request['level'],
                'content'  => $request['content']
            ]
        );
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
        $this->validate(
            $request, [
                        'title'    => 'string|min:3|max:200',
                        'subtitle' => 'string|min:3|max:200|nullable',
                        'content'  => 'string|min:3|nullable',
                        'display'  => 'boolean',
                        'level'    => 'integer',
                        'id'       => 'exists:goods_categories,id|required'
                    ]
        );
        GoodCategoriesModel::where('id', $request['id'])->update(
            [
                'title'    => $request['title'],
                'subtitle' => $request['subtitle'],
                'display'  => $request['display'],
                'level'    => $request['level'],
                'content'  => $request['content']
            ]
        )
        ;
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
        $this->validate(
            $request, [
                        'id' => 'exists:goods_categories,id|required'
                    ]
        );
        GoodCategoriesModel::where('id', $request['id'])->update(['status' => 0]);
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
        $this->validate(
            $request, [
                        'title'           => 'string|min:3|max:200',
                        'qps'             => 'string|nullable',
                        'php_version'     => 'string|nullable',
                        'mysql_version'   => 'string|nullable',
                        'db_quota'        => 'string|nullable',
                        'domain'          => 'string|nullable',
                        'max_connect'     => 'string|nullable',
                        'max_worker'      => 'string|nullable',
                        'doc_root'        => 'string|nullable',
                        'web_quota'       => 'string|nullable',
                        'speed_limit'     => 'string|nullable',
                        'log_handle'      => 'string|nullable',
                        'type'            => 'string|nullable',
                        'module'          => 'string|nullable',
                        'subdir'          => 'string|nullable',
                        'subdir_flag'     => 'string|nullable',
                        'db_type'         => 'string|nullable',
                        'flow_limit'      => 'string|nullable',
                        'max_subdir'      => 'string|nullable',
                        'time'            => 'string|nullable',
                        'ftp'             => 'string|nullable',
                        'template'        => 'string|nullable',
                        'config_template' => 'string|nullable',
                        'free_domain'     => 'string|nullable',
                        'language'        => 'string|nullable',
                        'maxsql'          => 'string|nullable',
                        'useregns'        => 'string|nullable',
                        'hasuseregns'     => 'string|nullable',
                        'forcedns'        => 'string|nullable',
                        'reseller'        => 'string|nullable',
                        'cgi'             => 'string|nullable',
                        'maxftp'          => 'string|nullable',
                        'maxpop'          => 'string|nullable',
                        'maxpark'         => 'string|nullable',
                        'maxaddon'        => 'string|nullable',
                        'customip'        => 'string|nullable',
                    ]
        );

        GoodConfigureModel::create(
            [
                'title'           => $request['title'],
                'qps'             => $request['qps'],
                'php_version'     => $request['php_version'],
                'mysql_version'   => $request['mysql_version'],
                'db_quota'        => $request['db_quota'],
                'domain'          => $request['domain'],
                'max_connect'     => $request['max_connect'],
                'max_worker'      => $request['max_worker'],
                'module'          => $request['module'],
                'doc_root'        => $request['doc_root'],
                'web_quota'       => $request['web_quota'],
                'speed_limit'     => $request['speed_limit'],
                'log_handle'      => $request['log_handle'],
                'subdir'          => $request['subdir'],
                'type'            => $request['type'],
                'subdir_flag'     => $request['subdir_flag'],
                'db_type'         => $request['db_type'],
                'flow_limit'      => $request['flow_limit'],
                'max_subdir'      => $request['max_subdir'],
                'time'            => $request['time'],
                'ftp'             => $request['ftp'],
                'template'        => $request['ftp'],
                'config_template' => $request['template'],
                'free_domain'     => $request['config_template'],
                'language'        => $request['language'],
                'useregns'        => $request['useregns'],
                'hasuseregns'     => $request['hasuseregns'],
                'forcedns'        => $request['forcedns'],
                'reseller'        => $request['reseller'],
                'cgi'             => $request['cgi'],
                'maxsql'          => $request['maxsql'],
                'maxftp'          => $request['maxftp'],
                'maxpop'          => $request['maxpop'],
                'maxpark'         => $request['maxpark'],
                'maxaddon'        => $request['maxaddon'],
                'customip'        => $request['customip'],
            ]
        );

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
        $this->validate(
            $request, [
                        'title'           => 'string|min:3|max:200',
                        'qps'             => 'string|nullable',
                        'php_version'     => 'string|nullable',
                        'mysql_version'   => 'string|nullable',
                        'db_quota'        => 'string|nullable',
                        'domain'          => 'string|nullable',
                        'max_connect'     => 'string|nullable',
                        'max_worker'      => 'string|nullable',
                        'doc_root'        => 'string|nullable',
                        'web_quota'       => 'string|nullable',
                        'speed_limit'     => 'string|nullable',
                        'log_handle'      => 'string|nullable',
                        'subdir'          => 'string|nullable',
                        'subdir_flag'     => 'string|nullable',
                        'db_type'         => 'string|nullable',
                        'flow_limit'      => 'string|nullable',
                        'max_subdir'      => 'string|nullable',
                        'time'            => 'string|nullable',
                        'ftp'             => 'string|nullable',
                        'type'            => 'string|nullable',
                        'module'          => 'string|nullable',
                        'id'              => 'exists:goods_configure,id|required',
                        'template'        => 'string|nullable',
                        'config_template' => 'string|nullable',
                        'free_domain'     => 'string|nullable',
                        'language'        => 'string|nullable',
                        'maxsql'          => 'string|nullable',
                        'useregns'        => 'string|nullable',
                        'hasuseregns'     => 'string|nullable',
                        'forcedns'        => 'string|nullable',
                        'reseller'        => 'string|nullable',
                        'cgi'             => 'string|nullable',
                        'maxftp'          => 'string|nullable',
                        'maxpop'          => 'string|nullable',
                        'maxpark'         => 'string|nullable',
                        'maxaddon'        => 'string|nullable',
                        'customip'        => 'string|nullable',
                    ]
        );

        GoodConfigureModel::where(
            [
                ['status', '!=', '0'],
                ['id', $request['id']]
            ]
        )->update(
            [
                'title'           => $request['title'],
                'qps'             => $request['qps'],
                'php_version'     => $request['php_version'],
                'mysql_version'   => $request['mysql_version'],
                'db_quota'        => $request['db_quota'],
                'domain'          => $request['domain'],
                'max_connect'     => $request['max_connect'],
                'max_worker'      => $request['max_worker'],
                'doc_root'        => $request['doc_root'],
                'web_quota'       => $request['web_quota'],
                'speed_limit'     => $request['speed_limit'],
                'log_handle'      => $request['log_handle'],
                'module'          => $request['module'],
                'subdir'          => $request['subdir'],
                'subdir_flag'     => $request['subdir_flag'],
                'db_type'         => $request['db_type'],
                'flow_limit'      => $request['flow_limit'],
                'max_subdir'      => $request['max_subdir'],
                'time'            => $request['time'],
                'ftp'             => $request['ftp'],
                'template'        => $request['ftp'],
                'config_template' => $request['template'],
                'free_domain'     => $request['config_template'],
                'language'        => $request['language'],
                'useregns'        => $request['useregns'],
                'hasuseregns'     => $request['hasuseregns'],
                'forcedns'        => $request['forcedns'],
                'reseller'        => $request['reseller'],
                'cgi'             => $request['cgi'],
                'maxsql'          => $request['maxsql'],
                'maxftp'          => $request['maxftp'],
                'maxpop'          => $request['maxpop'],
                'maxpark'         => $request['maxpark'],
                'maxaddon'        => $request['maxaddon'],
                'customip'        => $request['customip'],
            ]
        )
        ;

        return redirect(route('admin.good.show'));
    }

    public function goodConfigureDelAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        //        dd($request->id);
        $this->validate(
            $request, [
                        'id' => 'exists:goods_configure,id|required'
                    ]
        );
        GoodConfigureModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.good.show'));
    }

    /**
     * 商品添加操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function goodAddAction(Request $request)
    {
        AdminController::checkAdminAuthority(Auth::user());
        $this->validate(
            $request, [
                        'title'          => 'string|min:3|max:200',
                        'price'          => 'numeric',
                        'subtitle'       => 'string|min:3|max:200|nullable',
                        'description'    => 'string|min:3|nullable',
                        'display'        => 'boolean',
                        'level'          => 'integer',
                        'configure'      => 'nullable|exists:goods_configure,id',
                        'server'         => 'nullable|exists:servers,id|nullable',
                        'categories'     => 'nullable|exists:goods_categories,id',
                        'purchase_limit' => 'nullable|integer',
                        'inventory'      => 'nullable|integer',
                        'domain_config'  => 'nullable|integer',
                    ]
        );

        !empty($purchase_limit) ?: $purchase_limit = 0;

        GoodModel::create(
            [
                'title'          => $request['title'],
                'subtitle'       => $request['subtitle'],
                'price'          => round(abs($request['price']), 2),
                'description'    => $request['description'],
                'level'          => $request['level'],
                'display'        => $request['display'],
                'configure_id'   => $request['configure'],
                'categories_id'  => $request['categories'],
                'server_id'      => $request['server'],
                'inventory'      => $request['inventory'],
                'domain_config'  => $request['domain_config'],
                'purchase_limit' => $purchase_limit
            ]
        );

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
        $this->validate(
            $request, [
                        'title'          => 'string|min:3|max:200',
                        'price'          => 'numeric',
                        'subtitle'       => 'string|min:3|max:200|nullable',
                        'description'    => 'string|min:3|nullable',
                        'display'        => 'boolean',
                        'level'          => 'integer',
                        'configure'      => 'nullable|exists:goods_configure,id',
                        'server'         => 'nullable|exists:servers,id|nullable',
                        'categories'     => 'nullable|exists:goods_categories,id',
                        'id'             => 'exists:goods,id|required',
                        'purchase_limit' => 'nullable|integer',
                        'inventory'      => 'nullable|integer',
                        'domain_config'  => 'nullable|integer',
                    ]
        );

        !empty($purchase_limit) ?: $purchase_limit = 0;

        GoodModel::where(
            [
                ['id', $request['id']],
                ['status', '!=', '0']
            ]
        )->update(
            [
                'title'          => $request['title'],
                'subtitle'       => $request['subtitle'],
                'price'          => round(abs($request['price']), 2),
                'description'    => $request['description'],
                'level'          => $request['level'],
                'display'        => $request['display'],
                'configure_id'   => $request['configure'],
                'categories_id'  => $request['categories'],
                'server_id'      => $request['server'],
                'inventory'      => $request['inventory'],
                'domain_config'  => $request['domain_config'],
                'purchase_limit' => $purchase_limit
            ]
        )
        ;

        return back()->with(['status' => 'success']);
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
        $this->validate(
            $request, [
                        'id' => 'exists:goods,id|required'
                    ]
        );
        GoodModel::where('id', $request['id'])->update(['status' => 0]);
        return redirect(route('admin.good.show'));
    }
}

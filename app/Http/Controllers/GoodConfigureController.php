<?php

namespace App\Http\Controllers;

use App\GoodConfigureModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodConfigureController extends Controller
{

    public $virtual_host_configure_form
        = [
            'php_version'     => 'PHP版本',
            'mysql_version'   => 'Mysql版本',
            'db_quota'        => '数据库大小',
            'web_quota'       => 'Web空间大小',
            'module'          => '模块',
            'speed_limit'     => '速度限制',
            'flow_limit'      => '流量限制',
            'max_connect'     => '最大连接数',
            'domain'          => '最大绑定域名',
            'doc_root'        => '主机主目录',
            'log_handle'      => '是否开启日记分析',
            'subdir'          => '默认绑定目录',
            'max_worker'      => '最多工作者',
            'subdir_flag'     => '是否允许绑定子目录',
            'max_subdir'      => '最多子目录(域)数',
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
            'email_notice'        => '邮件通知',
        ];

    public $virtual_private_server_configure_form
        = [
            'template'        => '面板页面模板',
            'config_template' => '面板配置模板',
            'email_notice' => '邮箱通知',
            'module' => '虚拟化类型',
            'custommemory' => '自定义内存',
            'custombandwidth' => '自定义带宽',
            'group' => '服务器组',
            'hvmt' => 'hvmt',
            'vnc' => 'vnc',
            'customip' => '自定义服务器IP',
            'domain' => '允许域名数量',
        ];

    protected function validateConfigureData(Request $request)
    {
        $diyVaildate = [
            'title' => 'string|min:3|max:200',
            'time'  => 'string|nullable'
        ];
        foreach ($this->getConfigure() as $key => $value) {
            $vaildate[$key] = 'string|nullable';
        }
        $vaildate = array_merge($vaildate, $diyVaildate);
        $this->validate($request, $vaildate);
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
        $this->validateConfigureData($request);

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
                'template'        => $request['template'],
                'config_template' => $request['config_template'],
                'free_domain'     => $request['free_domain'],
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

    protected function getConfigure()
    {
        return array_merge($this->virtual_host_configure_form,$this->virtual_private_server_configure_form);
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
        $this->validateConfigureData($request);
        $this->validate(
            $request, [
                        'id' => 'exists:goods_configure,id|required',
                    ]
        );

        $configure = GoodConfigureModel::where(
            [
                ['status', '!=', '0'],
                ['id', $request['id']]
            ]
        )->first()
        ;

        foreach ($this->getConfigure() as $key => $value) {
            $configure->$key = $request[$key];
        }
        $configure->save();

        return redirect(route('admin.good.show'))->with(['status' => 'success']);
    }

    /**
     * 删除操作
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
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
}

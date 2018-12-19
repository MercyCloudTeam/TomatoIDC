<?php

namespace App\Http\Controllers;

use App\GoodCategoriesModel;
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


    public function getConfigureFromInput($type)
    {
        $goodsConfigure = new GoodConfigureController();
        switch ($type) {
            case "virtual_host":
                return $goodsConfigure->virtual_host_configure_form;
                break;
            case "virtual_private_server":
                return $goodsConfigure->virtual_private_server_configure_form;
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

        return redirect(route('admin.good.show'))->with(['status', 'success']);
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
        GoodModel::where('id', $request['id'])->delete();
        return redirect(route('admin.good.show'))->with(['status', 'success']);
    }
}

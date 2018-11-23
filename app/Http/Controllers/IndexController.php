<?php

namespace App\Http\Controllers;

use App\GoodCategoriesModel;
use App\GoodModel;

class IndexController extends Controller
{

    /**
     * 视图代码View
     */

    /**
     * 返回首页视图
     */
    public function indexPage()
    {
        $this->middleware('check.install.status');
        return view(ThemeController::backThemePath('index'));
    }

    /**
     * 返回登陆视图
     */
    public function loginPage()
    {
        return view(ThemeController::backThemePath('login', 'auth'));
    }

    /**
     * 获取商品
     * @return null
     */
    protected function getGoods()
    {
        $goods = GoodModel::where([
            ['status', '!=', '0'],
            ['display',1]
        ])->orderBy('level', 'desc')->get();
        !$goods->isEmpty() ?: $goods = null;
        return $goods;
    }

    /**
     * 返回登陆视图
     */
    public function registerPage()
    {
        return view(ThemeController::backThemePath('register', 'auth'));
    }

    /**
     * 商品列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodShowPage()
    {
        $goodsCategories = $this->getGoodsCategories();
        $goods = $this->getGoods();
        return view(ThemeController::backThemePath('show', 'home.goods'), compact('goods', 'goodsCategories'));
    }

    /**
     * 操作代码
     */

    /**
     * 获取商品分类
     * @return null
     */
    protected function getGoodsCategories()
    {
        $goods_categories = GoodCategoriesModel::where([
            ['status', '!=', '0'],
            ['display',1]
        ])->orderBy('level', 'desc')->get();
        !$goods_categories->isEmpty() ?: $goods_categories = null;
        return $goods_categories;
    }


    /**
     * 临时监控实现自动删除主机
     * TODO 以后版本会使用任务
     * 后续会废除
     * @return int
     */
    public function tempCronAction()
    {
        $hostController =new HostController();
        $hosts = $hostController->checkHostStatus();
        $hosts = null;
        return time();
    }


}

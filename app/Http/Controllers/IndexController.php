<?php

namespace App\Http\Controllers;

use App\GoodCategoriesModel;
use App\GoodModel;
use App\Http\Controllers\Payment\PayController;
use App\Http\Resources\GoodCollection;
use App\Http\Resources\GoodsCategoriesResource;
use App\User;
use Illuminate\Http\Request;

/**
 * 返回首页以及不需要登陆验证的视图
 * Class IndexController
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{

    /**
     * 视图代码View
     */

    public $version = "V0.1.6";//发布版本号

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
            ['display', 1]
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
     * user email validate action
     * @param $id string url_path(url/{id}/token)
     * @param $token string url_path(url/id/{token}
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userEmailTokenValidate($id,$token)
    {
        $token=htmlspecialchars(trim($token));
        $user = User::where('id',htmlspecialchars(trim($id)))->get();
        if(!$user->isEmpty()){
            $user= $user->first();
            if ($user->email_validate != 0){
                return redirect('/home');
            }
            $encrypt = md5($user->email.substr(env('APP_KEY'),15,31).$user->id.$user->updated_at);
            if ($encrypt == $token){
                User::where('id',$id)->update(['email_validate'=>1]);
                return redirect('/home');
            }
        }
        return response()->json([
            'status' => 'failure',
            'date' => []
        ]);
    }


    /**
     * API代码
     */

    public function apiLoginAction(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * 获取商品列表
     * @return GoodCollection|bool 成功JSON 失败返回null
     */
    public function getGoodListApi()
    {
        $goods = GoodModel::where([
            ['status', '!=', '0'],
            ['display', 1]
        ])->orderBy('level', 'desc')->get()->makeHidden([
            'created_at',
            'updated_at',
            'stock',
            'display',
            'configure_id',
            'server_id'
        ]);
        !$goods->isEmpty() ?: $goods = null;
        if ($goods) {
            return GoodCollection::make($goods);
        }
        return json_encode(['status' => 500]);
    }

    /**
     * 获取商品分类
     * @param $name string 商品分类名称
     * @return GoodsCategoriesResource|string 成功返回商品分类详细json 失败返回500 json
     */
    public function getGoodCategoriesApi($name)
    {
        $name = htmlspecialchars(trim($name));
        $categories = GoodCategoriesModel::where([
            ['title', $name],
            ['status', '!=', '0'],
            ['display', 1]
        ])->get()->makeHidden([
            'created_at',
            'updated_at',
            'display',
        ]);;
        !$categories->isEmpty() ? $categories = $categories->first() : $categories = null;
        if ($categories) {
            return new GoodsCategoriesResource($categories);
        }
        return json_encode(['status' => 500]);
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
            ['display', 1]
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
        $hostController = new HostController();
        $payController = new PayController();
        $hosts = $hostController->autoCheckHostStatus();
        $order = $payController->autoCheckOrderStatus();
        $recharge = $payController->autoCheckRechargeStatus();
        return time();
    }


}

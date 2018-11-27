<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//登陆 登出 注册 视图和操作

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::middleware(['check.install.status', 'throttle:60,1'])->group(function () {//安装路由
    Route::get('install', 'InstallController@installPage');
    Route::post('install', 'InstallController@installAction');
});

Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/', "IndexController@indexPage");//首页视图
    Route::get('login', 'IndexController@loginPage')->name('login');//注册视图
    Route::get('register', 'IndexController@registerPage')->name('register');//登录视图
    Route::post('login', 'Auth\LoginController@login');//登陆操作
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');//登出操作
    Route::post('register', 'Auth\RegisterController@register');//注册操作
    Route::get('goods/show', 'IndexController@goodShowPage')->name('good.show');//商品列表
});


Route::any('/{payment}/order/notify', 'Payment\PayController@notify');//支付回调
Route::get('/temp/cron', "IndexControaller@tempCronAction");//临时监控

Route::prefix('admin')->group(function () {//管理路由
    Route::middleware(['auth', 'check.admin.authority', 'throttle:60,1'])->group(function () {
        Route::name('admin.')->group(function () {
            Route::get('/', 'AdminController@indexPage')->name('home');
            Route::prefix('user')->group(function () { //用户
                Route::get('show', 'AdminController@userShowPage');
                Route::get('add', 'AdminController@userAddPage')->name('user.add');
                Route::post('add', 'AdminController@userEditPage');
                Route::get('edit', 'AdminController@userEditPage')->name('user.edit');
                Route::post('edit', 'AdminController@userEditPage');
            });
            Route::prefix('order')->group(function () { //订单
                Route::get('show', 'AdminController@orderShowPage')->name('order.show');
                Route::get('edit/{no}', 'AdminController@orderEditPage')->name('order.edit');
                Route::post('edit', 'OrderController@orderEditAction');
            });
            Route::prefix('host')->group(function () { //主机
                Route::get('show', 'AdminController@hostShowPage')->name('host.show');
                Route::post('create/host/re', 'HostController@reCreateHost')->where(['id' => '^[0-9]*$']);
            });
            Route::prefix('work/order')->group(function () { //工单
                Route::get('show', 'AdminController@workOrderShowPage')->name('work.order.show');
                Route::get('detailed/{id}', 'AdminController@workOrderDetailedPage')->name('work.order.detailed')->where(['id' => '^[0-9]*$']);
                Route::post('close', 'WorkOrderController@workOrderCloseAction')->name('work.order.close');
                Route::post('reply', 'WorkOrderController@workOrderAdminReplyAction')->name('work.order.reply');
            });
            Route::prefix('new')->group(function () { //新闻
                Route::get('show', 'AdminController@newShowPage')->name('new.show');
                Route::get('add', 'AdminController@newAddPage')->name('new.add');
                Route::post('add', 'NewController@newAddAction');
                Route::get('edit/{id}', 'AdminController@newEditAction')->name('new.edit');
                Route::post('edit', 'NewController@newEditAction');
                Route::post('del', 'NewController@newDelAction')->name('new.del');
            });
            Route::prefix('good')->group(function () { //商品
                Route::get('show', 'AdminController@goodShowPage')->name('good.show');
                Route::get('add', 'AdminController@goodAddPage')->name('good.add');
                Route::get('categories/add', 'AdminController@goodCategoriesAddPage')->name('good.categories.add');
                Route::get('categories/edit/{id}', 'AdminController@goodCategoriesEditPage')->name('good.categories.edit')->where(['id' => '^[0-9]*$']);
                Route::get('configure/edit/{id}', 'AdminController@goodConfigureEditPage')->name('good.configure.edit')->where(['id' => '^[0-9]*$']);
                Route::post('categories/add', 'GoodController@goodCategoriesAddAction');
                Route::post('categories/edit', 'GoodController@goodCategoriesEditAction');
                Route::post('categories/del', 'GoodController@goodCategoriesDelAction')->name('good.categories.del');
                Route::post('configure/del', 'GoodController@goodConfigureDelAction')->name('good.configure.del');
                Route::get('configure/add', 'AdminController@goodConfigureAddPage')->name('good.configure.add');
                Route::get('edit/{id}', 'AdminController@goodEditPage')->name('good.edit');
                Route::post('add', 'GoodController@goodAddAction');
                Route::post('configure/add', 'GoodController@goodConfigureAddAction');
                Route::get('edit', 'AdminController@userEditPage');
                Route::post('edit', 'GoodController@goodEditAction');
                Route::post('configure/edit', 'GoodController@goodConfigureEditAction');
                Route::post('del', 'GoodController@goodDelAction')->name('good.del');
            });
            Route::prefix('user')->group(function () { //全局设置
                Route::get('show', 'AdminController@userShowPage')->name('user.show');
                Route::get('add', 'AdminController@userEditPage');
                Route::post('add', 'AdminController@userEditPage');
                Route::get('edit/{id}', 'AdminController@userEditPage')->name('user.edit');
                Route::post('edit', 'UserController@userEditAction');
            });
            Route::prefix('setting')->group(function () { //全局设置
                Route::get('/', 'AdminController@settingIndexPage')->name('setting.index');
                Route::get('{payment}/pay/config', 'AdminController@paymentPluginConfigPage')->name('setting.pay');
                Route::post('pay/config', 'AdminController@paymentPluginConfigAction');
                Route::post('/', 'AdminController@settingEditAction');
                Route::get('edit', 'AdminController@userEditPage');
                Route::post('edit', 'AdminController@userEditPage');
            });
            Route::prefix('server')->group(function () { //服务器设置
                Route::get('show', 'AdminController@serverShowPage')->name('server.show');
                Route::get('add', 'AdminController@serverAddPage')->name('server.add');
                Route::get('status/{id}', 'ServerController@serverStatusPage')->name('server.status')->where(['id' => '^[0-9]*$']);
                Route::post('add', 'ServerController@serverAddAction');
                Route::get('edit/{id}', 'AdminController@serverEditPage')->name('server.edit')->where(['id' => '^[0-9]*$']);
                Route::post('edit', 'ServerController@serverEditAction');
                Route::post('del', 'ServerController@serverDelAction')->name('server.del');
            });
            Route::prefix('prepaid/key')->group(function () {
               Route::get('show','AdminController@prepaidKeyShowPage')->name('prepaid.key.show');
               Route::get('add','AdminController@prepaidKeyAddPage')->name('prepaid.key.add');
               Route::post('add','PrepaidKeyController@addKeyAction');
            });
        });

    });
});


Route::prefix('home')->group(function () {//首页路由
    Route::middleware(['auth', 'throttle:60,1'])->group(function () {
        Route::get('/', 'HomeController@indexPage')->name('home');//用户中心视图

        Route::get('user/profile', 'HomeController@userProfilePage')->name('user.profile');//个人信息视图
        Route::post('user/profile', 'HomeController@userProfileAction');//个人信息操作

        Route::get('buy/{id}', 'HomeController@goodsBuyPage')->name('good.buy');//个人信息视图
        Route::get('pay/{no}', 'HomeController@rePayOrderPage')->name('order.pay.no')->where(['no' => '^[0-9]*$']);//订单未支付再次支付
        Route::get('renew/{id}', 'HomeController@renewHostPage')->name('host.renew')->where(['id' => '^[0-9]*$']);//续费主机
        Route::post('renew/host', 'OrderController@renewHostAction')->name('host.renew.action');//续费主机
        Route::post('pay/re', 'OrderController@rePayOrderAction')->name('order.pay.re');//再次支付

        Route::get('workorder/show', 'HomeController@workOrderShowPage')->name('work.order.show');//工单列表
        Route::get('workorder/add', 'HomeController@workOrderAddPage')->name('work.order.add');//工单添加
        Route::post('workorder/add', 'WorkOrderController@workOrderAddAction')->name('work.order.add');//工单添加

        Route::get('host/show', 'HomeController@hostShowPage')->name('host.show');//主机列表
        Route::get('host/detailed/{id}', 'HomeController@hostDetailedPage')->name('host.detailed');//主机详细

        Route::get('new/show', 'HomeController@newShowPage')->name('new.show');//新闻列表
        Route::get('new/{id}', 'HomeController@newPostPage')->name('new.post')->where(['id' => '^[0-9]*$']);//新闻列表

        Route::get('order/show', 'HomeController@orderShowPage')->name('order.show');//新闻列表
        Route::post('order/create', 'OrderController@orderCreateAction')->name('order.create');//消息列表
        Route::any('order/status', 'OrderController@orderCheckStatusAction')->name('order.status');//订单状态

        Route::get('work/order/detailed/{id}', 'HomeController@workOrderDetailedPage')->name('work.order.detailed')->where(['id' => '^[0-9]*$']);
        Route::get('order/detailed/{id}', 'HomeController@orderDetailedPage')->name('order.detailed')->where(['no' => '^[0-9]*$']);
        Route::post('reply', 'WorkOrderController@workOrderReplyAction')->name('work.order.reply');//工单回复

        Route::get('user/recharge','HomeController@userRechargePage')->name('user.recharge');//用户充值
        Route::post('user/recharge/pay','UserRechargeController@userRechargePayAction')->name('user.recharge.pay');//用户操作
        Route::any('user/recharge/status','UserRechargeController@userRechargeCheckStatusAction')->name('user.recharge.status');
        Route::post('user/recharge/prepaid/key','PrepaidKeyController@rechargePrepaidKeyAction')->name('prepaid.key');//卡米充值
    });
});

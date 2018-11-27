<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('orders', function (Blueprint $table) {//订单表
            $table->increments('id');
            $table->integer('good_id');
            $table->string('no');
            $table->integer('user_id');
            $table->integer('host_id')->nullable();
            $table->integer('status')->default(1);
            $table->integer('aff_no')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->double('sale')->default(0);
            $table->double('price');
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) { //优惠卷
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->longText('content');
            $table->double('price');
            $table->string('order_id')->nullable();
            $table->string('type')->nullable();
            $table->string('key')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) { //设置
            $table->increments('id');
            $table->string('name');
            $table->string('value')->nullable();
            $table->timestamps();
        });

        Schema::create('news', function (Blueprint $table) { //新闻
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->longText('subtitle');
            $table->longText('description');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('work_order', function (Blueprint $table) { //工单
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->longText('content');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('work_order_reply', function (Blueprint $table) { //工单回复
            $table->string('work_order_id');
            $table->string('content');
            $table->integer('user_id');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('plugins', function (Blueprint $table) { //插件状态 暂无使用
            $table->increments('id');
            $table->string('title');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('message', function (Blueprint $table) { //消息通知 暂无使用
            $table->string('title');
            $table->string('content');
            $table->integer('user_id');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('users_aff', function (Blueprint $table) {//推荐者
            $table->string('no');
            $table->integer('user_id');
            $table->integer('status')->default(1);
            $table->integer('sale')->default(0);
            $table->timestamps();
        });

        Schema::create('servers', function (Blueprint $table) { //服务器
            $table->increments('id');
            $table->string('title');
            $table->string('ip');
            $table->string('token')->nullable();
            $table->string('configure')->nullable();
            $table->string('key')->nullable();
            $table->string('port')->nullable();
            $table->string('plugin')->nullable();
            $table->integer('categories_id')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });


        Schema::create('hosts', function (Blueprint $table) { //主机信息
            $table->increments('id');
            $table->string('order_id');
            $table->integer('user_id');
            $table->string('host_name');
            $table->string('host_pass');
            $table->string('host_panel');
            $table->string('host_url')->nullable();
            $table->string('host_ip')->nullable();
            $table->string('description')->nullable();
            $table->integer('status')->default(1);
            $table->dateTime('deadline')->nullable();
            $table->timestamps();
        });

        Schema::create('goods', function (Blueprint $table) {//商品表
            $table->increments('id');
            $table->string('title');
            $table->double('price');
            $table->string('type')->nullable();
            $table->string('level')->default(1);
            $table->integer('status')->default(1);
            $table->integer('display')->default(1);
            $table->integer('stock')->nullable();
            $table->integer('categories_id')->nullable();
            $table->longText('configure_id')->nullable();//配置 json/序列化存储
            $table->integer('server_id')->nullable();
            $table->longText('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        Schema::create('goods_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('display')->default(1);
            $table->string('level')->default(1);
            $table->string('content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('servers_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('display')->default(1);
            $table->string('level')->default(1);
            $table->string('content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::create('goods_configure', function (Blueprint $table) { //商品配置
            $table->increments('id');
            $table->string('title');
            $table->string('type')->nullable();
            $table->string('qps')->nullable();
            $table->string('php_version')->nullable();
            $table->string('subtemplete')->nullable();
            $table->string('templete')->nullable();
            $table->string('module')->nullable();
            $table->string('mysql_version')->nullable();
            $table->string('db_quota')->nullable();
            $table->string('domain')->nullable();
            $table->string('max_connect')->nullable();
            $table->string('max_worker')->nullable();
            $table->string('doc_root')->nullable();
            $table->string('web_quota')->nullable();
            $table->string('speed_limit')->nullable();
            $table->string('log_handle')->nullable();
            $table->string('subdir')->nullable();
            $table->string('subdir_flag')->nullable();
            $table->string('db_type')->nullable();
            $table->string('flow_limit')->nullable();
            $table->string('max_subdir')->nullable();
            $table->string('ftp')->nullable();
            $table->string('access')->nullable();
            $table->string('hvmt')->nullable();
            $table->string('group')->nullable();
            $table->string('custommemory')->nullable();
            $table->string('overover')->nullable();
            $table->string('custombandwidth')->nullable();
            $table->string('time')->nullable();
            $table->integer('status')->default(1);
            $table->string('json_configure')->nullable();//使用json保存配置信息
            $table->timestamps();
        });

        Schema::create('prepaid_keys', function (Blueprint $table) {
            $table->string('key');
            $table->double('account');
            $table->integer('user_id')->nullable();
            $table->dateTime('deadline')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        Schema::create('user_recharge', function (Blueprint $table) {
            $table->string('no');
            $table->string('user_id');
            $table->string('type')->nullable();
            $table->double('money');
            $table->integer('status')->default(1);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plugins');
        Schema::dropIfExists('work_order');
        Schema::dropIfExists('work_order_reply');
        Schema::dropIfExists('users_aff');
        Schema::dropIfExists('message');
        Schema::dropIfExists('prepaid_keys');
        Schema::dropIfExists('goods');
        Schema::dropIfExists('goods_configure');
        Schema::dropIfExists('goods_categories');
        Schema::dropIfExists('servers_categories');
        Schema::dropIfExists('news');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('hosts');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('user_recharge');
        Schema::dropIfExists('servers');
    }
}

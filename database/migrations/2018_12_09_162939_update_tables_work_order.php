<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTablesWorkOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'work_order', function (Blueprint $table) { //添加字段
            $table->string('order_no')->nullable();  //订单no
            $table->string('priority')->nullable();  //优先级
            $table->softDeletes();
        }
        );
        Schema::create(
            'auth_log', function (Blueprint $table) { //用户登录记录
            $table->string('mode'); //page jwt api?
            $table->string('user_id')->nullable();
            $table->string('token')->nullable();
            $table->string('status')->default(1);
            $table->timestamps();
        }
        );
        Schema::table(
            'servers', function (Blueprint $table) {
            $table->longText('ip_list')->nullable();
            $table->string('key2')->nullable();
            $table->string('port2')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('nodegroup')->nullable();
            $table->string('token2')->nullable();
            $table->softDeletes();
        }
        );
        Schema::table(
            'hosts', function (Blueprint $table) {
            $table->string('server_id')->nullable();
            $table->string('host_pass2')->nullable();
            $table->string('host_name2')->nullable();
            $table->string('console_user')->nullable();
            $table->string('console_password')->nullable();
            $table->softDeletes();
            $table->string('dns1')->nullable();
            $table->string('dns2')->nullable();
            $table->string('dns3')->nullable();
            $table->string('dns4')->nullable();
        }
        );

        Schema::table(
            'goods_configure', function (Blueprint $table) {
            $table->longText('ip_list')->nullable(); //ip列表以,分割
            $table->longText('mac')->nullable(); //ip列表以,分割
            $table->longText('vnc')->nullable(); //开通vnc
            $table->string('template')->nullable(); // 面板页面模板
            $table->string('config_template')->nullable(); // 面板配置模板
            $table->string('email_notice')->default(0); // 邮箱通知
            $table->string('network_speed')->nullable(); // 网速限制
            $table->string('free_domain')->nullable(); //免费二级域名
            $table->string('language')->nullable(); //默认语言
            $table->string('useregns')->nullable(); //是否为域使用注册的域名服务器。
            $table->string('hasuseregns')->nullable(); //遗留参数
            $table->string('forcedns')->nullable(); //是否使用新帐户的信息覆盖现有DNS区域
            $table->string('reseller')->nullable(); //分销商
            $table->string('maxsql')->nullable(); //最大开通数据库数量
            $table->string('cgi')->nullable(); //CGi
            $table->string('maxftp')->nullable(); //最大开通FTP数量
            $table->string('maxpop')->nullable(); //帐户的最大电子邮件帐户数
            $table->string('maxpark')->nullable(); //帐户的最大停放域数（别名）
            $table->string('maxaddon')->nullable(); //帐户的最大插件域数。
            $table->string('customip')->nullable(); //手动指定ip
            $table->softDeletes();
        }
        );

        Schema::table(
            'orders', function (Blueprint $table) {
            $table->string('domain')->nullable();;
            $table->softDeletes();//软删除
        }
        );

        Schema::table(
            'goods_categories', function (Blueprint $table) {
            $table->softDeletes();//软删除
        }
        );
        Schema::table(
            'users_aff', function (Blueprint $table) {
            $table->softDeletes();//软删除
        }
        );
        Schema::table(
            'news', function (Blueprint $table) {
            $table->softDeletes();//软删除
        }
        );
        Schema::table(
            'goods', function (Blueprint $table) {
            $table->string('domain_config')->default(0);//是否要配置域名，默认不配置
            $table->string('month_price')->nullable();//每三十天多少钱
            $table->softDeletes();//软删除
        }
        );

        Schema::create(
            'user_action_log', function (Blueprint $table) { //用户操作记录，debug用
            $table->string('mode'); //page jwt api?
            $table->string('user_id')->nullable();
            $table->string('action')->nullable();
            $table->string('payload')->nullable();
            $table->string('status')->default(1);
            $table->string('token')->nullable();
            $table->timestamps();
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_log');
        Schema::dropIfExists('user_action_log');
    }
}

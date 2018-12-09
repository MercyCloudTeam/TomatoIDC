<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_level', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('level_code');//等级代码（标示）这可能不是一个好更改
            $table->string('user_authority')->nullable();
            $table->double('price');
            $table->integer('inventory')->nullable();
            $table->longText('description')->nullable();
            $table->integer('status')->default(1);
            $table->integer('purchase_limit')->default(0);//限購
            $table->integer('upgrade')->default(0);//升级
            $table->integer('sale_percentage')->default(0);//用户购买折扣，百分比 （单独可使用优惠卷）
            $table->integer('aff_percentage')->default(0);//用户推广返利 百分比
            $table->integer('aff_money')->default(0);//用户推广返利 固定
            $table->string('json_configure')->nullable();//使用json保存配置信息
            $table->timestamps();
        });
        Schema::create('user_authority', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('api')->default(0);
            $table->string('distribution')->default(0);
            $table->string('aff')->default(0);
            $table->string('json_configure')->nullable();//使用json保存配置信息
            $table->timestamps();
        });
        Schema::table('goods', function (Blueprint $table) { //添加字段
            $table->integer('inventory')->nullable();
            $table->integer('servers_categories_id')->nullable();//可以不使用单独服务器使用服务器组
            $table->integer('purchase_limit')->default(0);//限購
            $table->integer('upgrade')->default(0);//升级
        });
        Schema::table('users', function (Blueprint $table) { //添加字段
            $table->integer('email_validate')->default(0);
            $table->integer('phone_validate')->default(0);
            $table->string('wechat_openid')->nullable();
            $table->string('level_code')->nullable();//这可能不是一个好更改
            $table->integer('real_name_validate')->default(0);
        });
        Schema::create('diy_page', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash');
            $table->longText('content');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        Schema::create('servers_area', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('xyz')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
        Schema::table('servers', function (Blueprint $table) { //添加字段
            $table->integer('area_id')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) { //添加字段
            $table->string('json_configure')->nullable();//定制配置，满足特别的用户w
        });
        Schema::table('goods_configure', function (Blueprint $table) { //添加字段
            $table->string('customcpunum')->nullable();  //CPU数量
            $table->string('customdisk')->nullable();  //自定义硬盘大小
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servers_area');
        Schema::dropIfExists('user_authority');
        Schema::dropIfExists('diy_page');
        Schema::dropIfExists('user_level');
    }
}

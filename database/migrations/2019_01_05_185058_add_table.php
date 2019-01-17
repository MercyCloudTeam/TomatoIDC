<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //临时url
        Schema::create('temp_url', function (Blueprint $table) {
            $table->string('url')->unique();
            $table->string('params')->nullable();
            $table->string('hour');//时间 以小时为单位
            $table->timestamps();
        });

        //多周期计费
        Schema::create('charging', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time');
            $table->string('unit');
            $table->double('money');
            $table->string('status')->default(1);
            $table->string('renew')->default(1);
            $table->integer('good_id');
            $table->string('automatic')->default(1);
            $table->string('content')->nullable();//备注
            $table->softDeletes();//软删除
            $table->timestamps();
        });

        //主机
        Schema::table(
            'hosts', function (Blueprint $table) {
            $table->string('panel_id')->nullable();//第三方管理面板开通id
            $table->string('panel_name')->nullable();//对接面板开通名称
        }
        );

        //软件安装表
        Schema::create('software', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');//路径
            $table->string('params')->nullable();
            $table->string('title');//标题
            $table->string('content');//备注
            $table->string('version')->nullable();//版本
            $table->string('status')->default(1);
            $table->softDeletes();//软删除
            $table->timestamps();
        });

        //软件配置表
        Schema::create('goods_software', function (Blueprint $table) {
            $table->increments('id');
            $table->string('software_id');//路径
            $table->string('goods_id')->nullable();
            $table->string('content')->nullable();//备注
            $table->string('version')->nullable();//版本
            $table->string('status')->default(1);
            $table->softDeletes();//软删除
            $table->timestamps();
        });

        //用户推广
        Schema::create('user_aff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('owner_user_id');//推广人id
            $table->string('aff_user_id');//被推广id
            $table->string('params')->nullable();
            $table->string('status')->default(1);
            $table->softDeletes();//软删除
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
        Schema::dropIfExists('temp_url');
        Schema::dropIfExists('charging');
        Schema::dropIfExists('software');
        Schema::dropIfExists('user_aff');
        Schema::dropIfExists('users_aff');
        Schema::dropIfExists('goods_software');
    }
}

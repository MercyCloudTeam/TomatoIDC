<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('user_id');//创建者id

            $table->string('title')->nullable();

            $table->bigInteger('billing_id')->nullable();//当前计费id
            $table->bigInteger('product_id')->nullable();//购买商品ID

            $table->string('type');//vps oss ecs 是服务器还是虚拟主机
            $table->longText('user_config')->nullable();//用户配置、选择系统、注入密码、用户名等....
            $table->integer('status')->default(1);
            $table->integer('sub_status')->default(0);
            $table->dateTime('expired_at')->nullable();//过期时间

            $table->boolean('auto_renew')->default(false);//是否开启自动续费
            $table->boolean('postpaid')->default(0);//后付费（也就是你们说的按量付费）

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('services_addons',function (Blueprint $table){
            $table->bigInteger('service_id')->index();//服务的ID
            $table->string('key');
            $table->longText('value');
            $table->double('price')->default(0);//附加项价格 如果是ip一个ip 就直接 50，如果是附加1T流量，则也记录直接的费用。如果是后付费带宽则记录单价、例如95计费
            $table->string('description')->nullable();//附加项名称
            $table->boolean('postpaid')->default(0);//后付费（也就是你们说的按量付费）//例如附加带宽50M

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
        Schema::dropIfExists('services');
        Schema::dropIfExists('services_addons');
    }
}

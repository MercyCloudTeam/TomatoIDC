<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('orders_log')
        Schema::table('orders', function (Blueprint $table) { //添加字段
            $table->longText('description')->nullable();
            $table->string('payment')->nullable();
            $table->string('api_no')->nullable();
        });
        Schema::table('user_recharge', function (Blueprint $table) { //添加字段
            $table->string('payment')->nullable();
            $table->string('api_no')->nullable();
        });
        Schema::create('wechat_message',function (Blueprint $table){
            $table->string('openid');
            $table->longText('message');
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
        Schema::dropIfExists('wechat_message');
    }
}

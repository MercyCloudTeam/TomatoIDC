<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //设计源自 MercyCloud Core Project
        //原详细设计文档 https://mercycloud.coding.net/p/cloud/wiki/12

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');//商品类型，ecs vps...
            $table->integer('level')->default(1);
            $table->integer('status')->default(1);
            $table->boolean('display')->default(true);
            $table->integer('stock')->default(-1);
            $table->integer('max')->default(100);//最大购买，一次性限购
            //符合中国大陆含税计算方法(增值电信业务一般6%，普通货物是13%
            $table->integer('tax')->default(6);//税率
            $table->boolean('review')->default(0);//强制要求审核

            $table->bigInteger('category_id')->nullable();
            $table->longText('subtitle')->nullable();
            $table->longText('view')->nullable();//显示参数
            $table->longText('description')->nullable();//商品描述

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable();;//parent_uuid
            $table->string('title');
            $table->boolean('display')->default(true);
            $table->string('level')->default(1);
            $table->longText('view')->nullable();//显示参数
            $table->integer('status')->default(1);

            $table->softDeletes();
            $table->timestamps();
        });


        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('service_id')->nullable();//服务事件
            $table->boolean('read')->default(false);//閲讀，未點開則未讀
            $table->string('title');//通知内容
            $table->longText('content');//通知内容
            $table->string('notice_method')->nullable();//通知类型，1 邮件 2 WeChat 3 短信
            $table->timestamps();
        });

        //系统设置
        Schema::create('system_setups', function (Blueprint $table) { //设置
            $table->string('name')->unique()->index()->primary();
            $table->longText('value');
            $table->string('type')->default('system')->index();//类型
            $table->timestamps();
        });

        //账单商品
        Schema::create('invoices_goods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('invoice_no')->nullable();//商品所属账单
            $table->double('unit_price')->default(0);//单价
            $table->double('price')->default(0);//总价（折扣后）
            $table->double('total_price')->default(0);//总价（未折扣）
            $table->string('type')->default('product');//goods 代表商品计费、 billing代表特殊账单计费、diy表示自定义计费项、planConfigure 代表附加计费
            $table->integer('tax')->default(6);//税率
            $table->double('sale')->default(0);//
            $table->double('setup_fee')->default(0);
            $table->string('sale_name')->nullable();//折扣名称,如果有折扣名称则记录折扣名称
            $table->string('link')->nullable();//关联主商品，后续大量生成续费账单商品顺序不会换
            $table->string('remark')->nullable();//备注
            $table->string('unit')->default("CNY");//货币
            $table->string('quantity')->default(1);//数量
            $table->bigInteger('service_id')->nullable();//对应的服务ID
            $table->longText('config')->nullable();//商品配置
            $table->bigInteger('billing_id')->nullable();//购买时候计费id
            $table->integer('time_quantity')->default(1);//购买时长、如果计费模型是一个月并用户购买了一个月 则记录 1 ,如果计费模型是一个月用户购买了一年则记录12，根据计费类型

            $table->softDeletes();
            $table->timestamps();
        });

        //账单
        Schema::create('invoices', function (Blueprint $table) {
            $table->string('no')->unique()->index()->primary();//订单号
            $table->string('title');//订单名称
            $table->string('serial_number')->nullable();//接口订单号
            $table->double('total_price');//总计费用（未折扣）
            $table->double('sale')->default(0);//折扣费用(商品自带的折扣）/优惠活动、接口
            $table->double('marketing_costs')->default(0);//代金卷（折扣卷抵消金额） 营销费用
            $table->double('commission_charge')->default(0);//手续费，支付接口、其他渠道得到的手续费
            $table->double('price');//账单最终费用（计算折扣后）
            $table->double('amount')->nullable();//最终收到费用（实付款）（支付接口,未计算支付接口手续费
            $table->double('refund')->default(0);//退款金额，各种原因导致的退款
            $table->double('setup_fee')->default(0);
            $table->string('type');//package api 收款....
            $table->string('payment')->nullable();//支付接口/网关
            $table->string('account')->nullable();//支付账户
            $table->string('unit')->default("CNY");//货币
            $table->bigInteger('user_id'); //所属用户ID
            $table->integer('status')->default(1);
            $table->integer('sub_status')->default(0);
            $table->string('remark')->nullable();//备注
            $table->boolean('cycle')->default(false);//循环计费
            $table->dateTime('expired_at')->nullable();//订单过期时间
            $table->dateTime('payment_at')->nullable();//支付时间
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');//内容
            $table->longText('contact')->nullable();//聯係方式
            $table->string('type');
            $table->integer('priority')->default(10);//优先级
            $table->uuid('user_uuid')->nullable();
            $table->uuid('service_uuid')->nullable();
            $table->integer('admin_id')->nullable();//分配管理員、上一次、目前正在处理的管理员
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tickets_reply', function (Blueprint $table) {
            $table->id();
            $table->longText('contact')->nullable();//聯係方式
            $table->string('type');
            $table->boolean('admin')->default(false);//如果是true则说明是管理员回复的
            $table->bigInteger('user_id')->nullable();
            $table->string('ticket_id');
            $table->longText('content');
            $table->longText('confidential')->nullable();//机密信息
            $table->integer('status')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });


        //多周期计费
        Schema::create('billing', function (Blueprint $table) {
            $table->id();
            $table->integer('time');//时长
            $table->string('cycle');//周期类型 (年 月 日 小时)
            $table->string('type');// 基础计费、CPU计费、服务器机房、运维计费、附加硬盘
//            //符合中国大陆含税计算方法(增值电信业务一般6%，普通货物是13%
            $table->double('price');//金额(此处金额为已含税
            $table->double('setup_fee')->default(0);//设置费、初装费、第一次购买时候付
            $table->string('status')->default(true);
            $table->boolean('display')->default(true);//是否可见
            $table->boolean('buy')->default(true);//能否购买
            $table->boolean('renew')->default(true);//能否续费
            $table->boolean('postpaid')->default(false);//后付费（也就是你们说的按量付费）
            $table->boolean('auto_generate')->default(true);//自动生成计费，若关闭自动生成，则只输出有的时间
            $table->string('remark')->nullable();//备注

            $table->longText('view')->nullable();//显示参数
            $table->longText('config')->nullable();//配置参数
            $table->longText('sale')->nullable();//优惠，JSON配置年付95着、满1000减一百

            $table->softDeletes();
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
        Schema::dropIfExists('products');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('system_setups');
        Schema::dropIfExists('invoices_goods');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('tickets_reply');
        Schema::dropIfExists('billing');
    }
}

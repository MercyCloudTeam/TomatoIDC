<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Remark: 原本的设计是只对PVE进行支持，部分设置预留偏向PVE

        //设计源自 MercyCloud Automation Project
        //路径：database/migrations/2021_03_08_114117_create_server_table.php
        //原详细设计文档 https://mercycloud.coding.net/p/automation/wiki/2

        //2021.10.19 随想，将服务器抽象为后端的概念

        //服务器表
        Schema::create('backend', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();//节点代号
            $table->string('code',100)->nullable();//节点代号
            $table->integer('servers_connect_id');
            $table->integer('status')->default(1);//服务器状态
            $table->string('node')->nullable();
            $table->integer('token_id')->nullable();//登录账号ID
            $table->string('storage')->nullable();
            $table->longText('config')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->integer('record_id')->nullable();

            $table->unique('code');
        });

        //服务器连接表
        Schema::create('backend_connect', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(); //服务器名称
            $table->integer('status')->default(1);//服务器状态
            $table->ipAddress('host');//服务器地址
            $table->ipAddress('host_v6')->nullable();//服务器地址，如果有多地址也可以记录一下
            $table->string('method', 20)->nullable();//登陆方式
            $table->integer('port')->nullable();//服务器端口
            $table->string('type', 50);//服务器类型，Proxmox OpenStack
            $table->softDeletes();
            $table->timestamps();
        });

        //对应网络组件连接(VyOS
        Schema::create('backend_network',function (Blueprint $table){
            $table->id();
            $table->integer('server_token_id');
            $table->string('type',50);//vyos pfsense... frr
            $table->bigInteger('bgp')->nullable(false);//BGP
            $table->string('igp',30)->nullable();//IGP
            $table->ipAddress('router_id');
            $table->string('version');//记录系统版本

            $table->ipAddress('host');
            $table->ipAddress('host_v6')->nullable();//服务器地址，如果有多地址也可以记录一下
            $table->string('method', 20)->nullable();//登陆方式
            $table->integer('port')->nullable();//服务器端口
            $table->string('title', 100)->nullable(); //服务器名称
            $table->integer('status')->default(1);//服务器状态
            $table->longText('config');
            $table->timestamps();
        });

        //网络组件与服务器关联
        Schema::create('backend_network_association',function (Blueprint $table){
            $table->id();
            $table->longText('config');
            $table->integer('servers_network_id');
            $table->integer('server_id');
            $table->timestamps();
        });

        //服务器登陆令牌
        Schema::create('backend_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();//这个验证令牌等名称
            $table->boolean('api')->default(false);//
            $table->string('type');//令牌存储类型
            $table->string('username')->nullable();//登入账户
            $table->longText('password');//登入密码 密码或者Token甚至密钥
            $table->timestamps();
        });


        //服务器状态记录
        Schema::create('backend_status', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id');
            $table->longText('params');
            $table->dateTime('created_at');
        });

        //服务器资源池
        Schema::create('backend_resource_pool', function (Blueprint $table) {
            $table->id();
            $table->integer('title');//名称
            $table->longText('config');
            $table->string('code');//资源池代码
            $table->string('type');
            $table->integer('status')->default(1);//服务器状态
            $table->timestamps();
        });

        //服务器配置与关联
        Schema::create('backend_resource_pool_association',function (Blueprint $table){
            $table->id();
            $table->integer('servers_resource_pool_id');
            $table->integer('server_id');
            $table->timestamps();
        });

        //存放服务器配置等消息
        Schema::create('backend_setup', function (Blueprint $table) {
            $table->id();
            $table->string('name');//附加物品的类型/成品
            $table->string('type');//附加物品的类型/成品
            $table->longText('config');
            $table->integer('server_id');
            $table->timestamps();
        });


        //设计源自 MercyCloud Automation Project
        //database/migrations/2021_03_08_114032_create_i_p_address_table.php

        Schema::create('ip_pool', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->string('type')->default('machine');//ip類型 等待分配、预留、弹性IP elasticity retain
            $table->string('ip_type');//ip類型 ipv4 or ipv6
            $table->string('gateway')->nullable();//配置網關
            $table->integer('cidr');//这个网段的子网網掩
            $table->string('netmask')->nullable();
            $table->integer('subnet')->default(32);//这端IP的大小 ip size
            $table->string('mac')->nullable();//MAC地址
            $table->string('net_type')->default('virtio');//网卡类型/接入类型
            $table->string('config')->nullable();//另外配置，插件識別
            $table->integer('vlan')->nullable();//另外配置，插件識別
            $table->string('nat')->nullable();//如果有一对一NAT的ip段
            $table->timestamps();
        });

        Schema::create('ip_related', function (Blueprint $table) {
            $table->id();
            $table->integer('server_id')->nullable(); //服務器ID
            $table->integer('ip_pool_id')->nullable();
            $table->string('bridge')->nullable();//桥接的网卡

            $table->timestamps();
        });

        Schema::create('ip_allocation', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');

            $table->integer('ip_pool_id')->nullable();
            $table->integer('server_id')->nullable(); //服務器ID
            $table->string('type')->default('machine');

            $table->string('service_id')->nullable();//對應服務
            $table->string('user_id')->nullable();//归属用户ID
            $table->longText('filler')->nullable();//过滤器配置状态
            $table->boolean('secondary')->default(0);//IP地址是否為secondary （附加ip）
            $table->string('config')->nullable();//另外配置，插件識別
            $table->string('net_type')->default('virtio');//网卡类型/接入类型
            $table->integer('vlan')->nullable();//另外配置，插件識別
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
        Schema::dropIfExists('servers');
        Schema::dropIfExists('servers_connect');
        Schema::dropIfExists('servers_network');
        Schema::dropIfExists('servers_network_association');
        Schema::dropIfExists('servers_tokens');
        Schema::dropIfExists('servers_token_association');
        Schema::dropIfExists('servers_status');
        Schema::dropIfExists('servers_resource_pool');
        Schema::dropIfExists('servers_resource_pool_association');
        Schema::dropIfExists('servers_setup');

        Schema::dropIfExists('ip_pool');
        Schema::dropIfExists('ip_related');
        Schema::dropIfExists('ip_allocation');
    }
}

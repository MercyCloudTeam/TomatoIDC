<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('signature')->nullable();
            $table->string('address')->nullable();
            $table->string('qq')->nullable();
            $table->string('phone')->nullable();
            $table->string('token')->nullable();
            $table->string('wechat_token')->nullable();
            $table->string('qq_token')->nullable();
            $table->integer('account')->default(0);
            $table->integer('status')->default(1);
            $table->integer('level')->default(1);
            $table->integer('admin_authority')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

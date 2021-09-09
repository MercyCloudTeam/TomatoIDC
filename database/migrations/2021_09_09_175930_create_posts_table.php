<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //设计源自 MercyCloud Core Project
        //路径：database/migrations/2019_11_30_052804_create_posts_table.php
        //原详细设计文档 https://mercycloud.coding.net/p/cloud/wiki/12

        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content_type')->default('string');//纯文字 html markdown
            $table->string('type');//文章类型： 帮助中心 客户问答....
            $table->string('title');
            $table->boolean('login')->default(0);//是否要登陆后才能获取
            $table->string('source')->nullable();
            $table->string('subtitle')->nullable();
            $table->longText('content');
            $table->integer('category_id')->nullable();
            $table->integer('status')->default(1);
            $table->string('img')->nullable();//頭圖
            $table->timestamps();
        });

        Schema::create('posts_categories',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content')->nullable();
            $table->integer('status')->default(1);
            $table->integer('pid')->nullable();
            $table->integer('level')->default(1);
            $table->timestamps();
        });

        Schema::create('posts_tags',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('posts_id');
            $table->integer('tag_id');
            $table->timestamps();
        });


        Schema::create('tags',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('content')->nullable();
            $table->timestamps();
        });

        Schema::create('posts_comments',function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('posts_id');
            $table->bigInteger('user_id');
            $table->longText('content');
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
        Schema::connection('posts_mysql')->dropIfExists('posts');
        Schema::connection('posts_mysql')->dropIfExists('posts_tags');
        Schema::connection('posts_mysql')->dropIfExists('posts_categories');
        Schema::connection('posts_mysql')->dropIfExists('tags');
        Schema::connection('posts_mysql')->dropIfExists('posts_comments');
    }
}

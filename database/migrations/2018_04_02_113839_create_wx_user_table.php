<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wx_user',function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid')->comment('微信openID');
            $table->string('nickname')->comment('微信昵称');
            $table->string('avatar')->comment('微信头像');
            $table->tinyInteger('sex')->default(0)->comment('0:未知,1:男,2:女');
            $table->string('province')->comment('省份');
            $table->string('city')->comment('城市');
            $table->string('country')->comment('国家');
            $table->tinyInteger('is_subscribe')->comment('0未关注,1已关注');
            $table->bigInteger('subscribe_time')->comment('关注时间');
            $table->bigInteger('create_time')->comment('创建时间');
            $table->string('unionid')->comment('微信平台unionid');
            // $table->comment('微信用户信息表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('wx_user');
    }
}

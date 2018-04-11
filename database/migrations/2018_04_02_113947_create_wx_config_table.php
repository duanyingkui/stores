<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_config',function (Blueprint $table) {
            $table->increments('id');
            $table->string('appid',100)->nullable()->comment('微信公众号appid');
            $table->string('appsecret',200)->nullable()->comment('微信公众号appsecret');
            $table->string('appname',50)->nullable()->comment('公众号名称');
            $table->string('subscribe_url',500)->nullable()->comment('关注公众号引导页URL');
            $table->string('dev_url',500)->nullable()->comment('');
            $table->string('dev_token',200)->nullable()->comment('微信Token');
            $table->string('dev_aeskey',200)->nullable()->comment('');
            $table->tinyInteger('dev_encrypt_type')->default(0)->comment('0：明文，1：兼容，2：安全');
            $table->string('open_appid',100)->nullable()->comment('微信开放平台appid');
            $table->string('open_appsecret',200)->nullable()->comment('微信开放平台appsecret');
            // $table->comment('微信公众号配置表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wx_config');
    }
}

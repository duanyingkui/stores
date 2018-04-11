<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',10)->comment('用户名');
            $table->string('phone',11)->unique()->comment('手机号');
            $table->string('password',32)->comment('密码');
            $table->string('salt',4)->comment('盐值');
            $table->tinyInteger('status')->default(0)->comment('状态(0正常,1删除)');
            $table->integer('role_id',false,false)->comment('角色id');
            $table->tinyInteger('type')->comment('角色类型(0管理员,1员工,2客户,3供应商)');
            $table->string('name_quanpin')->nullable()->comment('拼音全拼');
            $table->string('name_jianpin')->nullable()->comment('拼音简拼');
            $table->tinyInteger('is_v')->nullable()->comment('认证状态(0未认证,1已认证)');
            $table->string('openid')->nullable()->comment('微信openID');
            $table->timestamps();
            // $table->comment('用户表');
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
        Schema::drop('user');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxAutoreplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wx_autoreply',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('title',100)->comment('规则名称');
            $table->tinyInteger('category')->default(0)->comment('类型，0：被添加自动回复(关注时回复)，1：消息自动回复（关键字匹配不到回复），2：关键词自动回复');
            $table->tinyInteger('type')->default(0)->comment('类型:1文本,2事件');
            $table->string('event')->comment('事件');
            $table->text('content')->comment('回复内容');
            $table->string('country')->comment('国家');
            $table->tinyInteger('status')->default(0)->comment('状态(0正常,1删除)');
            $table->bigInteger('create_time')->comment('创建时间');
            $table->bigInteger('update_time')->nullable()->comment('更新时间');
            // $table->comment('微信自动回复表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wx_autoreply');
    }
}

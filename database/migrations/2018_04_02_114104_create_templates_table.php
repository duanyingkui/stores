<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('模板名称');
            $table->string('demo_pic')->comment('demo图片');
            $table->longText('schema')->comment('模板内容');
            $table->bigInteger('create_time')->comment('创建时间');
            // $table->comment('模板消息表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('templates');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file',function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name')->comment('文件名');
            $table->string('file_path')->comment('文件路径');
            $table->string('phone',11)->comment('手机号');
            $table->tinyInteger('type')->comment('0:订单文件，1：产品文件');    
            $table->timestamps();    
            // $table->comment('文件表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('file');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_keyword',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100)->comment('关键词');
            $table->tinyInteger('reply_id')->default(0)->comment('规则id');
            $table->timestamps();
            // $table->comment('微信关键词回复表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wx_keyword');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('product_name')->comment('产品名称');
            $table->integer('unit_id',false,false)->comment('产品单位id');
            $table->decimal('price', 14, 2)->nullable()->comment('产品单价（暂不考虑）');
            $table->string('list_picture')->comment('产品首页图片');
            $table->string('album')->nullable()->comment('产品图集(暂时不用)');
            $table->text('content')->comment('产品详情');
            $table->tinyInteger('is_sku')->default(0)->comment('是否开启SKU（0不开启，1开启）');
            $table->longText('sku_info')->nullable()->comment('产品属性规格（存json）');
            $table->timestamps();    
            // $table->comment('产品表');
        });

        Schema::create('product_file',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->integer('file_id',false,false)->comment('文件id');
            $table->integer('product_id',false,false)->comment('产品id');
            // $table->comment('产品文件关系表');
        });

        Schema::create('product_sku',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');           
            $table->integer('product_id',false,false)->comment('产品id');
            $table->integer('sku_id',false,false)->comment('sku的id');
            $table->timestamps();
            // $table->comment('产品属性关系表');
        });

        Schema::create('product_unit',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');           
            $table->string('name',4)->comment('产品单位名字');
            $table->timestamps();
            // $table->comment('产品单位表');
        });

        Schema::create('product_variety',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');           
            $table->integer('product_id',false,false)->comment('产品id');
            $table->integer('variety_id',false,false)->comment('产品类型id');
            // $table->comment('产品类型关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product');
        Schema::drop('product_file');
        Schema::drop('product_sku');
        Schema::drop('product_unit');
        Schema::drop('product_variety');
    }
}

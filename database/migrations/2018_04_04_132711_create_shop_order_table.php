<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_order',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('order_number',100)->comment('订单编号');           
            $table->integer('cus_id',false,false)->comment('客户id');
            $table->integer('p_id',false,false)->comment('产品id');
            $table->text('p_details')->nullable()->comment('产品要求（客户要求）');
            $table->bigInteger('p_number')->comment('产品下单数量');
            $table->integer('order_file_id',false,false)->comment('文件与订单关系表的id');
            $table->tinyInteger('method')->comment('支付方式（0：其他，1：微信支付，2：支付宝支付， 3现金支付，4刷卡支付）');
            $table->tinyInteger('delivery')->comment('交货方式（0自提，1送货，发货）');
            $table->decimal('total')->comment('总金额（应付款）');
            $table->string('invoice')->nullable()->comment('开发票的票号');
            $table->decimal('deposit')->nullable()->comment('定金（实付款）');
            $table->integer('close_time')->nullable()->comment('结算日期');
            $table->tinyInteger('status')->comment('付款状态（0未结算，1已结算）');
            $table->integer('state_id',false,false)->comment('订单状态（待接单，制作中，等等）');
            $table->string('sku_item_id',40)->nullable()->comment('选择的sku属性id');
            $table->timestamps();
            // $table->comment('客户订单表');
        });

        Schema::create('shop_order_file',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');           
            $table->integer('order_id',false,false)->comment('订单id');
            $table->integer('file_id',false,false)->comment('文件id');
            $table->timestamps();
            // $table->comment('订单文件关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shop_order');
        Schema::drop('shop_order_file');
    }
}

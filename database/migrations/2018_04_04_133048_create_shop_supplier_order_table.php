<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopSupplierOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_supplier_order',function (Blueprint $table) {
            $table->increments('id');           
            $table->integer('shop_order_id',false,false)->comment('客户下单id');
            $table->integer('supplier_order_id',false,false)->comment('商家下单id');
            $table->timestamps();
            // $table->comment('下单关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shop_supplier_order');
    }
}

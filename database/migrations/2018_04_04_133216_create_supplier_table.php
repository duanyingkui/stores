<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('name',100)->comment('供应商名称');
            $table->char('phone',11)->comment('手机号'); 
            $table->string('address')->comment('供应商地址');   
            $table->timestamps();    
            // $table->comment('供应商表');
        });

        Schema::create('supplier_order',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->integer('sup_id',false,false)->comment('供应商id');
            $table->decimal('price',14,2)->comment('供应方产品单价'); 
            $table->integer('p_number',false,false)->comment('商家下单产品数量');
            $table->decimal('total',14,2)->comment('供应方产品总额');
            $table->decimal('pay',14,2)->comment('商家实付');
            $table->tinyInteger('method')->comment('支付方式');   
            $table->timestamps();    
            // $table->comment('商家订单表');
        });

        Schema::create('supplier_variety',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');           
            $table->integer('supplier_id',false,false)->comment('供应商id');
            $table->integer('variety_id',false,false)->comment('产品类型id');
            // $table->comment('供应商产品类型关系表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('supplier');
        Schema::drop('supplier_order');
        Schema::drop('supplier_variety');
    }
}

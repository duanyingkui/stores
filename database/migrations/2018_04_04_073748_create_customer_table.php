<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('name',50)->comment('客户名称');
            $table->string('linkman',20)->comment('下单人(联系人)');
            $table->char('phone',11)->comment('手机号');    
            $table->timestamps();    
            // $table->comment('客户表');
        });

        Schema::create('address',function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->increments('id');
            $table->string('consignee',10)->comment('收货人');
            $table->char('consignee_mobile',11)->comment('收货人电话号码');
            $table->string('address_name')->comment('地址名称');    
            $table->tinyInteger('status')->comment('地址状态（0为默认地址，1为非默认）');
            $table->integer('customer_id',false,false)->comment('客户id');
            $table->timestamps();    
            // $table->comment('地址表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('customer');
        Schema::drop('address');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->comment('员工姓名');
            $table->string('phone',11)->comment('手机号');    
            $table->timestamps();    
            // $table->comment('员工表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staff');
    }
}

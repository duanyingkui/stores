<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role',function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_name',45)->default('')->comment('权限节点名称');
            $table->tinyInteger('type')->default(1)->comment('菜单层级，一级菜单为1，二级为2，页面节点为3');            
            $table->timestamps();
            // $table->comment('菜单表');
        });

        Schema::create('node',function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',45)->default('')->comment('权限节点名称');
            $table->string('code',45)->default('')->comment('权限节点编号，如001');
            $table->integer('pid',false,false)->default(0)->comment('父级节点id');
            $table->tinyInteger('depth')->default(1)->comment('菜单层级，一级菜单为1，二级为2，页面节点为3');
            $table->string('path',50)->default('#')->comment('权限节点路径');
            $table->tinyInteger('type')->default(1)->comment('节点类型(0：menu，1：button，2：api)');
            $table->integer('sort_factor',false,false)->default(0)->comment('排序因子（越小越靠前）');
            $table->string('icon',45)->default('')->comment('菜单图标class名称');
            $table->tinyInteger('status')->default(0)->comment('状态（0：正常，1：已删除）');
            $table->timestamps();
            // $table->comment('菜单表');
        });

        Schema::create('role_node',function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id',false,false)->comment('角色id');
            $table->string('node_code',20)->comment('权限节点code');         
            // $table->comment('角色权限表');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role');
        Schema::drop('node');
        Schema::drop('role_node');
    }
}

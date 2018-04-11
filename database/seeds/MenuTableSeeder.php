<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//微信模块 1
        DB::table('node')->insert([
            'name' => '微信模块',
            'code' => '001',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/wx',
            'type'=> 0,
            'sort_factor'=> 999,
            'icon'=> 'ion-chatboxes',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '微信基础配置',
            'code' => '001001',
            'pid' => 1,
            'depth'=> 2,
            'path'=> '/wx/config',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-ios-gear-outline',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '模板消息配置',
            'code' => '001002',
            'pid' => 1,
            'depth'=> 2,
            'path'=> '/wx/template',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-chatbubble-working',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '微信菜单配置',
            'code' => '001003',
            'pid' => 1,
            'depth'=> 2,
            'path'=> '/wx/menu',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-navicon-round',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '自动回复配置',
            'code' => '001004',
            'pid' => 1,
            'depth'=> 2,
            'path'=> '/wx/reply',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-chatbubbles',
            'status'=> 0
        ]);
        //用户管理 6
        DB::table('node')->insert([
            'name' => '用户管理',
            'code' => '002',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/user',
            'type'=> 0,
            'sort_factor'=> 888,
            'icon'=> 'ion-android-person',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '用户列表',
            'code' => '002001',
            'pid' => 6,
            'depth'=> 2,
            'path'=> '/user/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-person-stalker',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '角色管理',
            'code' => '002002',
            'pid' => 6,
            'depth'=> 2,
            'path'=> '/role/list',
            'type'=> 0,
            'sort_factor'=> 3,
            'icon'=> 'ion-paintbrush',
            'status'=> 0
        ]);
        //系统首页 9
        DB::table('node')->insert([
            'name' => '系统首页',
            'code' => '003',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-ios-home',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '数据分析',
            'code' => '003001',
            'pid' => 9,
            'depth'=> 2,
            'path'=> '/',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);
        //订单管理 11
        DB::table('node')->insert([
            'name' => '订单管理',
            'code' => '004',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/order',
            'type'=> 0,
            'sort_factor'=> 1,
            'icon'=> 'ion-navicon-round',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '新增订单',
            'code' => '004001',
            'pid' => 11,
            'depth'=> 2,
            'path'=> '/order',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-navicon-round',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '订单列表',
            'code' => '004002',
            'pid' => 11,
            'depth'=> 2,
            'path'=> '/order/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-navicon-round',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '文件列表',
            'code' => '004003',
            'pid' => 11,
            'depth'=> 2,
            'path'=> '/order/file',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-document',
            'status'=> 0
        ]);

        //产品管理 15
        DB::table('node')->insert([
            'name' => '产品管理',
            'code' => '005',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/product',
            'type'=> 0,
            'sort_factor'=> 2,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '编辑产品',
            'code' => '005001',
            'pid' => 15,
            'depth'=> 2,
            'path'=> '/product/edit',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '产品列表',
            'code' => '005002',
            'pid' => 15,
            'depth'=> 2,
            'path'=> '/product/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '产品类型',
            'code' => '005003',
            'pid' => 15,
            'depth'=> 2,
            'path'=> '/product/variety',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => 'SKU管理',
            'code' => '005004',
            'pid' => 15,
            'depth'=> 2,
            'path'=> '/product/sku',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);

        //客户管理 20
        DB::table('node')->insert([
            'name' => '客户管理',
            'code' => '006',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/customer',
            'type'=> 0,
            'sort_factor'=> 3,
            'icon'=> 'ion-person-stalker',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '客户列表',
            'code' => '006001',
            'pid' => 20,
            'depth'=> 2,
            'path'=> '/customer/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> 'ion-navicon',
            'status'=> 0
        ]);

        //员工管理 22
        DB::table('node')->insert([
            'name' => '员工管理',
            'code' => '007',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/staff',
            'type'=> 0,
            'sort_factor'=> 4,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '员工列表',
            'code' => '007001',
            'pid' => 22,
            'depth'=> 2,
            'path'=> '/staff/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);

        //供应商管理 24
        DB::table('node')->insert([
            'name' => '供应商管理',
            'code' => '008',
            'pid' => 0,
            'depth'=> 1,
            'path'=> '/supplier',
            'type'=> 0,
            'sort_factor'=> 5,
            'icon'=> '',
            'status'=> 0
        ]);

        DB::table('node')->insert([
            'name' => '供应商列表',
            'code' => '008001',
            'pid' => 24,
            'depth'=> 2,
            'path'=> '/supplier/list',
            'type'=> 0,
            'sort_factor'=> 0,
            'icon'=> '',
            'status'=> 0
        ]);
    }
}

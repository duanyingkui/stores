<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'role_name' => '管理员',
            'type' => 0
        ]);

        DB::table('role')->insert([
            'role_name' => '客户',
            'type' => 0
        ]);

        DB::table('role')->insert([
            'role_name' => '员工',
            'type' => 0
        ]);

        DB::table('role')->insert([
            'role_name' => '供应商',
            'type' => 0
        ]);

        DB::table('role')->insert([
            'role_name' => '系统维护',
            'type' => 0
        ]);

        //角色对应的权限
        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '001',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '002',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '003',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '004',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '005',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '006',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '007',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 1,
            'node_code' => '008',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 3,
            'node_code' => '004',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 3,
            'node_code' => '005',
        ]);

        DB::table('role_node')->insert([
            'role_id' => 5,
            'node_code' => '001',
        ]);
    }
}

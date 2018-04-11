<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'name' => 'admin',
            'phone' => '15560109727',
            'password' => 'cdb026923ef12039bd33ac28bbf26d3d',
            'salt'=>'3ND5',
            'status'=> 0,
            'role_id'=> 1,
            'type'=> 1,
            'is_v'=> 0
        ]);

        //订单状态
        DB::table('state')->insert([
            'name' => '待接单'
        ]);

        DB::table('state')->insert([
            'name' => '已接单'
        ]);

        DB::table('state')->insert([
            'name' => '制作中'
        ]);

        DB::table('state')->insert([
            'name' => '已制作'
        ]);

        DB::table('state')->insert([
            'name' => '送货中'
        ]);

        DB::table('state')->insert([
            'name' => '已完成'
        ]);
    }
}

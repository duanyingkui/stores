<?php

use Illuminate\Database\Seeder;

class WeChatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wx_autoreply')->insert([
            'title' => '关注自动回复',
            'category' => 0,
            'type' => 1,
            'event'=> '',
            'content'=> '欢迎关注~微印商城，让你的生活更便利！',
            'status'=> 0
        ]);

        DB::table('wx_autoreply')->insert([
            'title' => '消息自动回复',
            'category' => 1,
            'type' => 1,
            'event'=> '',
            'content'=> '没有匹配到你需要的内容~',
            'status'=> 0
        ]);
    }
}

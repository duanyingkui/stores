<?php

namespace App\Models;

use DB;
use Log;

class User
{
    /*个人信息*/
    public static function get_info($user_login, $fields = null)
    {
        //TODO $fields 有值过滤返回字段,没有就取所有的
        $query = DB::table('march_user');
        $query->where(['user_login'=>$user_login]);
        if ($fields) {
            $query->select($fields);
        } else {
            $query->select('user_phone','user_name','user_pwd','user_login');
        }
        return $query->first();
    }

    /**
     * 根据login_openid获取用户信息
     * @param  [String] $openid  微信的OPENID
     * @return  Object
     */
    public static function get_user_by_openid($openid)
    {
        try {
            $user = DB::table("user")->where('openid', '=', $openid)->first();
            return $user;
        } catch (\Exception $e) {
            Log::info($e);
            return null;
        }
    }

    /**
     * 根据openid获取用户信息
     * @param  [String] $openid  微信的OPENID
     * @return  Object
     */
    public static function get_wx_user_by_openid($openid)
    {
        try {
            $user = DB::table("wx_user")->where("openid", $openid)->first();
            return $user;
        } catch (\Exception $e) {
            Log::info($e);
            return null;
        }
    }


}


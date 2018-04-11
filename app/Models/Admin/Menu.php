<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{
    //
    static function get_format_menu(){
        $menus = self::get_menu();
        return self::format_menu($menus);
    }

    private static function format_menu($menus){
        $data = [];
        foreach($menus as $v){
            if($v->depth == 1){
                $data[$v->id] = $v;
            }
        }
        //使sort_factor起作用，分两次循环（仅用code排序时，循环一次就够了）
        foreach($menus as $v){
            if($v->depth == 2){
                $data[$v->pid]->children[] = $v;
            }
        }
        return array_values($data);
    }

    static function get_format_role_menu(){
        $menus = self::get_role_menu();
        return self::format_menu($menus);
    }

    private static function get_role_menu(){
        $roleId = get_user_info()->role_id;
        $codes = DB::table('role_node')->where('role_id',$roleId)->pluck('node_code');

        $sql = 'select * from node where (1<>1 ';
        foreach($codes as $v){
            if(strlen($v) == 3){
                $sql .= " or `code` like '$v%' ";
            }
            if(strlen($v) == 6){
                $sql .= " or `code` like '$v%' or `code` = ".substr($v,0,3);
            }
        }
        return DB::select($sql.') and type=0 and status=0 order by sort_factor');
    }

    static function get_menu(){
        return DB::table('node')
            ->where('type',0)
            ->where('status',0)
            ->orderBy('sort_factor')
            ->get();
    }
}

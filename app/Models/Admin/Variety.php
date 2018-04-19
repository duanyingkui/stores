<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $table = 'variety';
    protected $fillable = ['id','name'];
    public $timestamps = false;

    /**
     * 查询所有产品单位
     */
    public static function get_variety(){
        return Variety::select('id','name as value')->get();
    }

}
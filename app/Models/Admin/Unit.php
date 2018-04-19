<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'product_unit';
    protected $fillable = ['id','name'];

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    /**
     * 查询所有产品单位
     */
    public static function get_units(){
        return Unit::select('id','name as value')->get();
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/28
 * Time: 20:39
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Order_file extends Model
{
    protected $table = 'shop_order_file';
    protected $fillable = ['order_id','file_id'];
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
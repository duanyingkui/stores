<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/11
 * Time: 4:38
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'shop_order';
    protected $fillable = ['id','order_number','cus_id','p_id','p_details','p_number','order_file_id','method','delivery','total','invoice','deposit','close_time','status','state_id','sku_item_id'];
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
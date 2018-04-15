<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/25
 * Time: 16:59
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = ['id','customer_id','address_name','status','consignee','consignee_mobile','code'];
    public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
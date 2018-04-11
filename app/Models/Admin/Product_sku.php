<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 1:05
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Product_sku extends Model
{
    protected $table = 'product_sku';
    protected $fillable = ['product_id','sku_code'];
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id','product_name'];

    public function skus()
    {
        return $this->belongsToMany('App\Models\Admin\Sku','product_sku');
    }
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
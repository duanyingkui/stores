<?php
/**
 * Created by PhpStorm.
 * User: zhihuiting
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id','product_name','unit_id','variety_id','content','is_sku'];

    public function skus()
    {
        return $this->belongsToMany('App\Models\Admin\Sku','product_sku');
    }
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    public function files()
    {
        return $this->belongsToMany('App\Models\Admin\File');
    }

    /**
     * 添加产品
     */
    public static function add_product($arr,$fileList){
        return Product::create($arr)->id;
    }
}
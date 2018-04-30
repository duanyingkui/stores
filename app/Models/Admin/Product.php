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

    public static function getOrderProduct()
    {
        return Product::select('id', 'product_name as value')->get();
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

    /**
     * 产品列表
     * 搜索
     */
    public static function get_product_list_paginate($page,$pageSize,$arr){
        $total = Product::count();
        if($arr == null){
            $product = Product::skip(($page-1)*$pageSize)
                ->take($pageSize)
                ->orderBy('id','desc')
                ->get();
        }else{
            $name = $arr['name'];
            if($name != ''){
                $query->where('name',$name);
            }
            $product = Product::skip(($page-1)*$pageSize)
                ->take($pageSize)
                ->orderBy('id','desc')
                ->get();
        }
        return ['total'=>$total,'product'=>$product];        
    }

    // /**
    //  * 搜索 产品列表
    //  */
    // public static function get_list($page,$pageSize,$arr){
        
    // }
}
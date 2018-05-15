<?php
/**
 * Created by PhpStorm.
 * User: zhihuiting
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use DB;

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
            //搜索，还没写
            $name = $arr['name'];
            if($name != ''){
                $query->where('name',$name);
            }
            $product = Product::skip(($page-1)*$pageSize)
                ->take($pageSize)
                ->orderBy('id','desc')
                ->get();
        }

        foreach($product as $pro){
            $unit = DB::table('product_unit')->where('id',$pro->unit_id)->first();
            $pro->unit_id = $unit->name;
        }
        return ['total'=>$total,'product'=>$product];        
    }

    /**
     * 删除产品（文件 sku）
     */                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
    static function delete_product($id){
        
    }

    /**
     * 获取产品sku
     * 搜索
     */
    static function product_sku_paginate($page,$pageSize,$arr,$id){
        $total = Product::find($id)->skus()->count();
        if($arr == null){
            $product_sku = Product::find($id)->skus()->get();
            // dd($product_sku);
            
            foreach($product_sku as $sku_item){
                $items = Item::getItem($sku_item->id);
                // dd($items);
                $itemstr = "";
                foreach($items as $item){
                    $item_name = $item->name;
                    $itemstr.="$item_name";
                    $itemstr.=",";
                    // var_dump($itemstr);
                }
                // dd($itemstr);
                $sku_item->item = $itemstr;
            }

            // dd($product_sku);
        }else{
            //搜索
        }
        // dd($product_sku);
        return ['total'=>$total,'product_sku'=>$product_sku];      
    }

}
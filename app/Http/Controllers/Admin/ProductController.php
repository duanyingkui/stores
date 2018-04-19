<?php
/**
 * Created by PhpStorm.
 * User: zhihuiting
 * Date: 2018/3/26
 * Time: 21:26
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Admin\Unit;
use App\Models\Admin\Variety;
use App\Models\Admin\Product;
use App\Models\Admin\Files;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * 文件上传
     */
    public function set_imglist(Request $request)
    {
        if (!$request->hasFile('file')) {
            return responseToJson(1, '上传文件为空！');
        }
        $file = $request->file('file');
        $old = $file->getClientOriginalName();
        if (!$file->isValid()) {
            return responseToJson(2, '(' . $old . ')文件上传出错！');
        }
        $size = $file->getSize();
        $maxSize = 2 * 1024 * 1024;
//        $realPath = $file->getRealPath();
        if ($size > $maxSize) {
            return responseToJson(3, '单个文件不能超过2M！');
        }
        $ext = $file->getClientOriginalExtension();
        $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext; 
        if (Storage::disk('productFiles')->put($filename, File::get($file))) {
            $file_info = array("original" => $old, "name" => $filename, "size" => $size, "ext" => $ext);
            return responseToJson(0, 'success', $file_info);
        } else {
            return responseToJson(4, '(' . $old . ')文件保存出错！');
        }
    }

    /**
     * 删除文件
     */
    public function deleteFile($path)
    {
        Storage::disk('productFiles')->delete($path);
    }

    /**
     * 获取所有产品单位
     */
    public function get_units(){
        $units = Unit::get_units();
        if($units){
            return responseToJson(0,'success',$units);    
        }else{
            return responseToJson(1,'单位获取失败！');
        }
    }

    /**
     * 获取所有产品类型
     */
    public function get_variety(){
        $variety = Variety::get_variety();
        if($variety){
            return responseToJson(0,'success',$variety);    
        }else{
            return responseToJson(1,'单位获取失败！');
        }
    }

    /**
     * 添加产品
     */
    public function add_product(Request $request){
        $arr['product_name'] = $request->input('name');
        $sku                 = $request->input('sku');
        $arr['unit_id']      = $request->input('unit');
        $arr['variety_id']   = $request->input('type');
        $arr['content']      = $request->input('desc');
        $fileList            = $request->input('fileList');
        $oneimg              = $request->input('oneimg');
        if($sku == true){
            $arr['is_sku']   = 1;
        }else{
            $arr['is_sku']   = 0; 
        }
        DB::beginTransaction();
        try{
            $product_id = Product::add_product($arr,$fileList);
            foreach($fileList as $file){
                Files::add_file($file['original'],$file['name'],1,$product_id);
            } 
            foreach($oneimg as $file){
                Files::add_file($file['original'],$file['name'],2,$product_id);
            }
            DB::commit();
            return responseToJson(0,'success');
        }catch (Exception $e){
            DB::rollback();
            foreach($fileList as $file){
                $this->deleteFile($file['name']);
            } 
            foreach($oneimg as $file){
                $this->deleteFile($file['name']);
            }
            Log::info($e);
            return responseToJson(1,"add_product error!");
        }
    }

}
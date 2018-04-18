<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
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

    public function get_variety(){
        $variety = Variety::get_variety();
        if($variety){
            return responseToJson(0,'success',$variety);    
        }else{
            return responseToJson(1,'单位获取失败！');
        }
    }

    public function add_product(Request $request){
        
    }

}
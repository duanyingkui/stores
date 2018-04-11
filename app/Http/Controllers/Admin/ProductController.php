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

class ProductController extends Controller
{
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
        $maxSize = 1 * 1024 * 1024;
//        $realPath = $file->getRealPath();
        if ($size > $maxSize) {
            return responseToJson(3, '单个文件不能超过1M！');
        }
        $ext = $file->getClientOriginalExtension();
        $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext; //命名格式有问题，现在改了可以用了
        if (Storage::disk('productFiles')->put($filename, File::get($file))) {
            $file_info = array("original" => $old, "name" => $filename, "size" => $size, "ext" => $ext);
            return responseToJson(0, 'success', $file_info);
        } else {
            return responseToJson(4, '(' . $old . ')文件保存出错！');
        }
    }
}
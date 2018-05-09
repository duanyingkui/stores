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
use Log;

class Files extends Model
{
    protected $table = 'file';
    protected $fillable = ['id','file_path','file_name','type'];

    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Admin\Product','product_file','file_id','product_id');
    }

    /**
     * 添加文件
     */
    public static function add_file($name,$path,$type,$product_id){
        $add_file = Files::create([
            'file_path'=>$path,
            'file_name'=>$name,
            'type'=>$type,
        ]);
        if($add_file->save()){
            $add_file = Files::where('file_path',$path)->first();
            $add_file->products()->attach($product_id);
        }
    }

    public static function getFiles($pageSize,$queryData){
        $files = DB::table('file')->leftJoin('shop_order_file', 'file.id', '=', 'shop_order_file.file_id')
            ->leftJoin('shop_order', 'shop_order_file.order_id', '=', 'shop_order.id')
            ->where('file.type',0)
            ->where('shop_order.order_number','like','%'.$queryData.'%')
            ->select('file.*','shop_order.order_number','shop_order.id as order_id')
            ->orderBy('shop_order.order_number')
            ->paginate($pageSize);
        return $files;
    }

    public static function deleteFile($fileId,$orderId,$fileName){
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'orderFiles'.DIRECTORY_SEPARATOR.$fileName);
        DB::beginTransaction();
        try{
            Order_file::where('file_id',$fileId)->where('order_id',$orderId)->delete();
            DB::table('file')->delete($fileId);
            DB::commit();
            $file = Files::where('file_path',$fileName)->first();
            if(file_exists($path) && !$file)
                unlink($path);
            return true;
        }catch (\Exception $e){
            Log::info($e);
            DB::rollback();
            return false;
        }
    }

    public static function deleteFiles($orderIds,$fileNames){
        DB::beginTransaction();
        try{
            foreach ($orderIds as $orderId){
                Order::find($orderId)->files()->delete();
                Order_file::where('order_id',$orderId)->delete();
            }
            DB::commit();

            foreach ($fileNames as $fileName){
                $path = storage_path('app'.DIRECTORY_SEPARATOR.'orderFiles'.DIRECTORY_SEPARATOR.$fileName);
                if(file_exists($path))
                    unlink($path);
            }
            return true;
        }catch (\Exception $e){
            Log::info($e);
            DB::rollback();
            return false;
        }
    }
}
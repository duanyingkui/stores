<?php
/**
 * Created by PhpStorm.
 * User: zhihuiting
 * Date: 2018/3/27
 * Time: 0:24
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

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
}
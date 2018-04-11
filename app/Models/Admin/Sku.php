<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 0:55
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $table = 'sku';
    protected $fillable = ['id','name'];
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
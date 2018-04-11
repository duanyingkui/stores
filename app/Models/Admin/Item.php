<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/27
 * Time: 0:57
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $fillable = ['id','name'];
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
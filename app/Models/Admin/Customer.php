<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/25
 * Time: 16:58
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['id','name','linkman','phone'];
    public function addresses(){
        return $this->hasMany('App\Models\Admin\Address');
    }
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/25
 * Time: 16:59
 */

namespace App\Models\Admin;


use Illuminate\Database\Eloquent\Model;
use DB;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = ['id','customer_id','address_name','status','consignee','consignee_mobile','code'];
    public $timestamps = true;
    public function fromDateTime($value){
        return strtotime(parent::fromDateTime($value));
    }

    public static function getDefaultAddress($id){
        return Address::where('customer_id',$id)->where('status',0)->first();
    }

    public static function getAddress($id){
        return Address::where('customer_id',$id)->get();
    }

    public static function setAddress($id,$customer_id){
        $address = Address::find($id);
        DB::beginTransaction();
        try{
            Address::where('customer_id',$customer_id)->where('status',0)->update(['status'=>1]);
            $address->status = 0;
            $address->save();
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollback();
            Log::info($e);
            return false;
        }
    }
}
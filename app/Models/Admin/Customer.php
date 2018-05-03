<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/25
 * Time: 16:58
 */

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Log;
use App\Models\Admin\Address;
use App\Models\Admin\User;
use App\Models\Admin\Customer;
use Illuminate\Support\Facades\DB;
use Response;

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

    public static function getCustomer($queryData,$pageSize){
    	if($queryData){
          $address = Customer::join('address','customer.id','=','address.customer_id')
            ->select('customer.id','customer.name','customer.linkman','address_name','customer.phone','customer.created_at')
            ->where('address.status',0)
            ->paginate($pageSize);
        }
        $address  = Customer::join('address','customer.id','=','address.customer_id')
            ->select('customer.id','customer.name','customer.linkman','address_name','customer.phone','customer.created_at')
            ->where([
              ['address.status','=', 0],
              ['customer.name','like','%'.$queryData.'%'],
            ])
            ->orWhere([
              ['address.status','=', 0],
              ['customer.linkman','like','%'.$queryData.'%'],
            ])
            ->paginate($pageSize);
        Log::info(json_encode($address));
        return $address;
    }

    /**
     * @Author    gaocuili
     * @DateTime  2018-04-20
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     [type]      $name      客户方
     * @param     [type]      $linkman   订单人
     * @param     [type]      $phone     联系方式
     * @param     [type]      $address_n 详细地址
     * @param     [type]      $code      省市区的code代码
     */
    public static function addCustomer($name,$linkman,$phone,$address_n,$code){
    	$customer   = new Customer;
        $address    = new Address;
        $user       = new User;
        $salt_data  = get_salt();
        DB::beginTransaction();
         try{

              $customer->name             = $name;
              $customer->linkman          = $linkman;
              $customer->phone            = $phone;
              $customer->save();

              $address->consignee         = $linkman;
              $address->consignee_mobile  = $phone;
              $address->address_name      = $address_n;
              $address->code              = $code;
              $address->status            = 0;
              $address->customer_id       = $customer->id;
              $address->save();

              $user->name     = $phone;
              $user->phone    = $phone;
              $user->password = encrypt_password("123456",$salt_data);
              $user->salt     = $salt_data;
              $user->status   = 0;
              $user->type     = 2;
              $user->save();

              DB::commit();
              return Response::json(['code' => 0 , 'msg' => '操作成功']);
          }catch (Exception $err){
              DB::rollback();
              Log::info($err);
              return Response::json(['code' => 1 , 'msg' => '操作失败']);
          }
    }

    /**
     * @Author    gaocuili
     * @DateTime  2018-04-20
     * 删除指定用户
     * @param     [type]      $customer_id 客户ID
     */
    public static function delCustomer($customer_id,$user){
    	DB::beginTransaction();
	    $delCustomer  = Customer::where('id',$customer_id)
	                              ->delete();
	    $delAddress  = Address::where('customer_id',$customer_id)
	                            ->delete();
	    $delUser = User::where('name',$user)
	                    ->update(['status'=>1]);

	    if($delCustomer && $delAddress && $delUser){
	        DB::commit();
	        return Response::json(['code' => 0 , 'msg' => '操作成功']);
	    }else{
	        DB::rollback();
	        return Response::json(['code' => 1 , 'msg' => '操作失败']);
	    }
    }

    /**
     * @Author    Cion
     * @DateTime  2018-04-20
     * 批量删除
     * @param     [type]      $customer_id 客户ID，数组
     */
    public static function delCustomersId($customerIds,$customerPhones){
        DB::beginTransaction();
        try {
            DB::table('customer')->delete($customerIds);
            DB::table('address')->whereIn('customer_id',$customerIds)->delete();
            DB::table('user')->whereIn('name',$customerPhones)->update([ 'status' => 1 ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::info($e);
            DB::rollback();
            return false;
        }

    }
    

	/**
     * @Author    gaocuili
     * @DateTime  2018-04-20
     * @copyright [copyright]
     * @license   [license]
     * @version   [version]
     * @param     [type]      $customer_id 客户ID
     */
    public static function getCustomerById($customer_id){
    	$customer_data  = Customer::find($customer_id);
      	$address_data   = Address::select('address_name','code')
            ->where('customer_id',$customer_id)->get();
      return Response::json(['customer' => $customer_data , 'address' => $address_data]);
    }
}
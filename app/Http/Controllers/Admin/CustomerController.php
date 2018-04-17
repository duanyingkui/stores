<?php 
 
namespace App\Http\Controllers\Admin;

use App\Models\Admin\Customer;
use App\Models\Admin\Address;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use Log;
use Redirect;

class CustomerController{
    //ORM模型，获取客户信息
    function getAllCustomer(Request $request){
        $pageSize   = $request->input('pageSize', 5);
        $queryData  = $request->input('queryData');
        if($queryData){
        $address  = Customer::join('address','customer.id','=','address.customer_id')
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
        return Response::json(['customer' => $address]);
    }

    //ORM模型，添加客户信息
    function addCustomer(Request $request){
        $name         = $request->input('name','');
        $linkman      = $request->input('linkman','');
        $phone        = $request->input('phone','');
        $address_n    = $request->input('address','');
        $code         = implode('/',$request->input('code'));
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

    /*
     * 根据指定ID查询客户信息->前台修改
     * @param Request $request
     */
    function getCustomer(Request $request){
        $customer_id    = $request->input('id');
        $customer_data  = Customer::find($customer_id);
        $address_data   = Address::select('address_name','code')
            ->where('customer_id',$customer_id)->get();
        return Response::json(['customer' => $customer_data , 'address' => $address_data]);
    }

   /**
    * [delCustomer 根据指定ID删除客户信息->前台修改]
    * @param  Request $request [description]
    * @return [type]           [description]
    */
    function delCustomer(Request $request){
        $customer_id  = $request->input('id');
        $user         = $request->input('phone');
        DB::beginTransaction();
        $delCustomer  = Customer::where('id',$customer_id)->delete();
        $delAddress  = Address::where('customer_id',$customer_id)->delete();
        $delUser = User::where('name',$user)->update(['status'=>1]);

        if($delCustomer && $delAddress && $delUser){
            DB::commit();
            return Response::json(['code' => 0 , 'msg' => '操作成功']);
        }else{
            DB::rollback();
            return Response::json(['code' => 1 , 'msg' => '操作失败' , 'delCustomer' => $delCustomer , 'delAddress' => $delAddress , 'delUser' => $delUser]);
        }
    }
}
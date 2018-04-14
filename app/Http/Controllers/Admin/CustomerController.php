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

  /*
    ORM模型，获取客户信息
  */
    function getAllCustomer(Request $request){

        $pageSize = $request->input('pageSize', 5);
        $address  = Customer::join('address','customer.id','=','address.customer_id')
            ->select('customer.id','customer.name','customer.linkman','address_name','customer.phone')
            ->where('address.status',0)
            ->paginate($pageSize);
        Log::info(json_encode($address));
        return Response::json(['customer' => $address]);
    }

  /*
    ORM模型，添加客户信息
  */
  function addCustomer(Request $request){

        $name         = $request->input('name','');
        $linkman      = $request->input('linkman','');
        $phone        = $request->input('phone','');
        $address_n      = $request->input('address','');
        $code         = implode('/',$request->input('code'));

        $customer   = new Customer;
        $address    = new Address;
        $user       = new User;
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

              $user->name     = $linkman;
              $user->phone    = $phone;
              $user->password = 1;
              $user->salt     = "3ND5";
              $user->status   = 1;
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
    根据制定ID查询客户信息
  */
  function getCustomer(Request $request){
      $customer = $request->input('id');

































  }
}
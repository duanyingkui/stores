<?php 
 /**
 * Created by Sublime.
 * User: gaocuili
 */   

  namespace App\Http\Controllers\Admin;

  use App\Models\Admin\Customer;
  use Illuminate\Http\Request;
  use Response;
  use Log;
  use Redirect;

class CustomerController{

  /*
    ORM模型，获取客户信息
  */
    function getAllCustomer(Request $request){

        $pageSize   = $request->input('pageSize', 5);
        $queryData  = $request->input('queryData');
        $address = Customer::getCustomer($queryData,$pageSize);
        return Response::json(['customer' => $address]);
    }

  /*
    ORM模型，添加客户信息
  */
  function addCustomer(Request $request){

        $name         = $request->input('name','');
        $linkman      = $request->input('linkman','');
        $phone        = $request->input('phone','');
        $address_n    = $request->input('address','');
        $code         = implode('/',$request->input('code'));
        $addCustomer  = Customer::addCustomer($name,$linkman,$phone,$address_n,$code);
        return Response::json(["addCustomer" => $addCustomer]);        
  }

  //   /*
  //    * 根据指定ID查询客户信息->前台修改
  //    * @param Request $request
  //    */
  // function getCustomer(Request $request){
  //     $customer_id    = $request->input('id');
  //     $customer_data  = Customer::find($customer_id);
  //     $address_data   = Address::select('address_name','code')
  //           ->where('customer_id',$customer_id)->get();
  //     return Response::json(['customer' => $customer_data , 'address' => $address_data]);
  // }


  /**
   * 根据指定ID删除客户信息->前台修改
   * @param Request $request
   */
  function delCustomer(Request $request){
    $customer_id  = $request->input('id');
    $user         = $request->input('phone');
    $delCustomer  = Customer::delCustomer($customer_id,$user);
    return Response::json(["delCustomer" => $delCustomer]);        
  }

//TODO:: 批量删除后台
}
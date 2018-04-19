<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:31
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin\Address;
use App\Models\Admin\Customer;
use App\Models\Admin\Item;
use App\Models\Admin\Order;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    function getCustomer(){
        $customers = Customer::select('id', 'name as value')->get();
        return responseToJson(0,'success',$customers);
    }

    function getDefaultAddress(Request $request){
        $id = $request->input('id');
        if ($id) {
            $address = Address::getDefaultAddress($id);
            if($address){
                return responseToJson(0,'success',$address);
            }
        }
        return responseToJson(1,'failed');
    }

    function getProduct(){
        $prodects = Product::getOrderProduct();
        return responseToJson(0,'success',$prodects);
    }

    function getSku(Request $request){
        $id = $request->input('id');
        if ($id) {
            $skus = Product::find($id)->skus;
            foreach($skus as $key => $sku){
                $skus[$key]->select = '';
                $skus[$key]->items = Item::getItem($sku->id);
            }
            return responseToJson(0,'success',$skus);
        }
        return responseToJson(1,'failed');
    }

    function getAddress(Request $request){
        $id      = $request->input('id');
        $address = Address::getAddress($id);
        if($address){
            return responseToJson(0,'success',$address);
        }
        return responseToJson(1,'failed');
    }

    function setAddress(Request $request){
        $id          = $request->input('id');
        $customer_id = $request->input('customer_id');
        if(Address::setAddress($id,$customer_id)){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'failed');
        }
    }

    function addAddress(Request $request){
        $id                 = $request->input('id');
        $customer_id        = $request->input('customer_id');
        $consignee          = $request->input('consignee');
        $consignee_mobile   = $request->input('consignee_mobile');
        $code               = implode('/',$request->input('code'));
        $status             = $request->input('status',1);
        $address_name       = $request->input('address_name');
        //TODO::后台验证
        $address       = Address::find($id);
        if(!$address){
            $address = new Address;
            $address->customer_id = $customer_id;
        }
        $address->consignee         = $consignee;
        $address->consignee_mobile  = $consignee_mobile;
        $address->address_name      = $address_name;
        $address->code              = $code;
        $address->status            = $status;
        $address->save();
        return responseToJson(0,'success',$address);
    }

    function deleteAddress(Request $request){
        $id = $request->input('id');
        Address::find($id)->delete();
        return responseToJson(0,'success');
    }

    function addOrder(Request $request){
        $cus_id             = $request->input('customer_id');
        $p_id               = $request->input('product_id');
        $show_user_defined  = $request->input('show_user_defined');
        $p_details          = $request->input('user_defined');
        $delivery           = $request->input('delivery_way_id');
        $method             = $request->input('pay_way_id');
        $total              = $request->input('should_pay');
        $deposit            = $request->input('fact_pay');
        $sku_item_id        = $request->input('item_ids');

        $order_number       = millisecond().str_rand(4);

        $data = [
            'order_number'  => $order_number,
            'cus_id'        => $cus_id,
            'p_id'          => $p_id,
            'method'        => $method,
            'deposit'       => $deposit,
            'total'         => $total,
            'delivery'      => $delivery
        ];

        if($show_user_defined)
            $data['p_details'] = $p_details;
        else
            $data['sku_item_id'] = $sku_item_id;


        if($total == $deposit){
            $data['close_time'] = millisecond();
            $data['status'] = 1;
        }

        Log::info($data);
        $order = Order::create($data);

        if($order)
            return responseToJson(0,'success');
        else
            return responseToJson(1,'failed');
    }

    function upload(Request $request){
        if (!$request->hasFile('file')) {
            return responseToJson(1, '上传文件为空！');
        }
        $file = $request->file('file');
        $old = $file->getClientOriginalName();
        if (!$file->isValid()) {
            return responseToJson(2, '(' . $old . ')文件上传出错！');
        }
        $size = $file->getSize();
        $maxSize = 10 * 1024 * 1024;
        if ($size > $maxSize) {
            return responseToJson(3, '单个文件不能超过10M！');
        }
        $destPath = storage_path('app/orderFiles');
        if (!file_exists($destPath))
            mkdir($destPath, 0777, true);
        $ext = $file->getClientOriginalExtension();
        $filename = create_uuid(). '.' . $ext;
        if ($file->move($destPath, $filename)) {
            $file_info = array("original" => $old,"path" => $destPath, "name" => $filename);
            return responseToJson(0, 'success', $file_info);
        } else {
            return responseToJson(4, '(' . $old . ')文件保存出错！');
        }

    }
}
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
use App\Models\Admin\Files;
use App\Models\Admin\Item;
use App\Models\Admin\Order;
use App\Models\Admin\Order_file;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;

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
        $files              = $request->input('files');

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

        DB::beginTransaction();
        try{
            $order = Order::create($data);
            foreach ($files as $file){
                $fileData = ['file_path' => $file['name'],'file_name' => $file['original'],'type' => 0];
                $fileRes = Files::create($fileData);
                Order_file::create(['order_id' => $order->id,'file_id' => $fileRes->id]);
            }
            DB::commit();
            return responseToJson(0,'success');
        }catch (Exception $e){
            DB::rollback();
            Log::info($e);
            return responseToJson(1,'failed');
        }
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
        $destPath = storage_path('app'.DIRECTORY_SEPARATOR.'orderFiles');
        if (!file_exists($destPath))
            mkdir($destPath, 0777, true);
        $ext = $file->getClientOriginalExtension();
        $filename = create_uuid(). '.' . $ext;
        if($ext != 'rar' && $ext != 'zip' && $ext != 'jpg' && $ext != 'jpeg' && $ext != 'png')
            return responseToJson(4, '(' . $old . ')文件格式错误！');
        if ($file->move($destPath, $filename)) {
            $file_info = array("original" => $old,"name" => $filename);
            return responseToJson(0, 'success', $file_info);
        } else {
            return responseToJson(5, '(' . $old . ')文件保存出错！');
        }
    }

    function getFiles(Request $request){
        $pageSize = $request->input('pageSize');
        $queryData = $request->input('queryData');
        $files = Files::getFiles($pageSize,$queryData);
        if($files)
            return responseToJson(0, 'success', $files);
        else
            return responseToJson(1, 'failed！');
    }

    function deleteFile(Request $request){
        $fileId  = $request->input('fileId');
        $orderId = $request->input('orderId');
        $fileName= $request->input('fileName');
        $res     = Files::deleteFile($fileId,$orderId,$fileName);
        if($res)
            return responseToJson(0, 'success');
        else
            return responseToJson(1, 'failed！');
    }

    function deleteFiles(Request $request){
        $orderIds  = $request->input('orderIds');
        $fileNames = $request->input('fileNames');
        $res     = Files::deleteFiles($orderIds,$fileNames);
        if($res)
            return responseToJson(0, 'success');
        else
            return responseToJson(1, 'failed！');
    }

    function downFile(Request $request){
        $fileName  = $request->input('fileName');
        $filePath  = $request->input('filePath');
        Log::info($fileName);
        Log::info($filePath);
        $path = storage_path('app'.DIRECTORY_SEPARATOR.'orderFiles'.DIRECTORY_SEPARATOR.$filePath);
        if(file_exists($path))
            return response()->download($path,$fileName);
        else
            return "<div style='width: 100%;text-align: center;font-size: 50px;color: red'>404 NOT FOUND</div>";
    }
}
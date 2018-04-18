<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:11
 */

Route::group(['prefix'=>"customer", 'namespace'=>'Admin'],function(){
// admin/customer/list
	Route::get("list",'CustomerController@getAllCustomer');
	Route::post("list/add","CustomerController@addCustomer");
    Route::get("list/get","CustomerController@getCustomer");
    Route::get("list/delete","CustomerController@delCustomer");
});
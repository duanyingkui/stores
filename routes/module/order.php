<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:10
 */

Route::group(['prefix' => 'order', 'namespace'=>'Admin'], function () {
    Route::post('getSku','OrderController@getSku');
    Route::post('getProduct','OrderController@getProduct');
    Route::post('getAddress','OrderController@getAddress');
    Route::post('setAddress','OrderController@setAddress');
    Route::post('addAddress','OrderController@addAddress');
    Route::post('getCustomer','OrderController@getCustomer');
    Route::post('deleteAddress','OrderController@deleteAddress');
    Route::post('getDefaultAddress','OrderController@getDefaultAddress');
    Route::post('addOrder','OrderController@addOrder');
    Route::post('upload','OrderController@upload');
    Route::get('getFiles','OrderController@getFiles');
    Route::post('deleteFile','OrderController@deleteFile');
    Route::post('deleteFiles','OrderController@deleteFiles');
    Route::get('downFile','OrderController@downFile');
});
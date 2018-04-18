<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:10
 */

Route::group(['prefix'=>"product" , 'namespace'=>'Admin'],function(){
    Route::post('set_imglist',['uses'=>'ProductController@set_imglist']);
    Route::post('add_product',['uses'=>'ProductController@add_product']);
    Route::get('get_units',['uses'=>'ProductController@get_units']);
    Route::get('get_variety',['uses'=>'ProductController@get_variety']);
});
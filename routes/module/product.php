<?php
/**
 * Created by PhpStorm.
 * User: zhihuiting
 * Date: 2018/3/26
 * Time: 21:10
 */

Route::group(['prefix'=>"product" , 'namespace'=>'Admin'],function(){
    Route::post('set_imglist',['uses'=>'ProductController@set_imglist']);
    Route::post('add_product',['uses'=>'ProductController@add_product']);
    Route::get('get_units',['uses'=>'ProductController@get_units']);
    Route::get('get_variety',['uses'=>'ProductController@get_variety']);

    Route::get('get_product_list_paginate',['uses'=>'ProductController@get_product_list_paginate']);
    Route::post('delete_product',['uses'=>'ProductController@delete_product']);
});
<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:10
 */

Route::group(['prefix'=>"product" , 'namespace'=>'Admin'],function(){
    Route::post('set_imglist',['uses'=>'ProductController@set_imglist']);
});
<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/3/26
 * Time: 21:13
 */

Route::group(['prefix'=>"staff", 'namespace'=>'Admin'],function(){
	Route::get("list",'StaffController@');
});
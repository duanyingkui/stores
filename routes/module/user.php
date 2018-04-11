<?php
/**
 * Created by PhpStorm.
 * User: duanyingkui
 * Date: 2018/3/26
 * Time: 21:13
 */

Route::group(['prefix'=>"user", 'namespace'=>'Admin'],function(){
    Route::get("role_list",'RoleController@get_role_list_paginate');
    Route::get('/role/get_role_list_paginate','User\RoleController@get_role_list_paginate');   //获取角色列表
    Route::get('/role/edit','User\RoleController@edit');   //角色编辑页面
    Route::post('/role/edit_save','User\RoleController@edit_save');   //角色保存
    Route::post('/role/delete','User\RoleController@delete');   //删除角色
});
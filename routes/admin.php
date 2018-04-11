<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('/menu/get', 'Wechat\MenuController@get_menu');
    Route::group(['prefix' => 'weixin'], function () {
        Route::post("/config/set", 'Wechat\WeixinController@set_config');
        Route::post("/config/get", 'Wechat\WeixinController@get_config');

        Route::post("/template/set", 'Wechat\WeixinController@set_wx_template');
        Route::post("/template/get", 'Wechat\WeixinController@get_wx_template');

        Route::post("/reply/get", 'Wechat\WeixinController@get_reply');
        Route::post("/reply/set", 'Wechat\WeixinController@set_reply');
        Route::post("/follow/set", 'Wechat\WeixinController@set_follow');
        Route::post("/news/set", 'Wechat\WeixinController@set_news');

        Route::post("/reply/create", 'Wechat\WeixinController@create_reply');
        Route::post("/reply/delete/{id}", 'Wechat\WeixinController@delete_reply');

        Route::post("/industry", 'Wechat\WeixinController@set_industry');
        Route::post("/update", 'Wechat\WeixinController@add_template');
        Route::post("/auto_update", 'Wechat\WeixinController@get_private_templates');
        Route::post("/menu/get", 'Wechat\WeixinController@get_menu');
        Route::post("/menu/set", 'Wechat\WeixinController@set_menu');

        Route::get('/group/get', 'Wechat\WeixinController@get_wx_group');
        Route::get('/group/set', 'Wechat\WeixinController@set_wx_group');
        Route::get('/group/move', 'Wechat\WeixinController@move_wx_group');
        Route::get('/group/del', 'Wechat\WeixinController@del_wx_group');
        Route::get('/group/menu/a/set', 'Wechat\WeixinController@set_wx_group_menu_a');
        Route::get('/group/menu/b/set', 'Wechat\WeixinController@set_wx_group_menu_b');
        Route::get('/menu/get', 'Wechat\WeixinController@get_wx_menu');
        Route::get('/user/menu/get', 'Wechat\WeixinController@get_wx_user_mennu');
    });

    /**
     * 订单管理
     */
    include('module/order.php');

    /**
     * 产品管理
     */
    include('module/product.php');

    /**
     * 客户管理
     */
    include('module/customer.php');

    /**
     * 供应商管理
     */
    include('module/supplier.php');

    /**
     *员工管理
     */
    include('module/staff.php');

    /**
     *用户管理
     */
    include('module/user.php');
});
/*Route::group(['prefix' => 'weixin'], function () {
    Route::post("/config/set", 'Admin\WeixinController@set_config');
    Route::post("/config/get", 'Admin\WeixinController@get_config');

    Route::post("/template/set", 'Admin\WeixinController@set_wx_template');
    Route::post("/template/get", 'Admin\WeixinController@get_wx_template');

    Route::post("/reply/get", 'Admin\WeixinController@get_reply');
    Route::post("/reply/set", 'Admin\WeixinController@set_reply');
    Route::post("/follow/set", 'Admin\WeixinController@set_follow');
    Route::post("/news/set", 'Admin\WeixinController@set_news');

    Route::post("/reply/create", 'Admin\WeixinController@create_reply');
    Route::post("/reply/delete/{id}", 'Admin\WeixinController@delete_reply');

    Route::post("/industry", 'Admin\WeixinController@set_industry');
    Route::post("/update", 'Admin\WeixinController@add_template');
    Route::post("/auto_update", 'Admin\WeixinController@get_private_templates');
    Route::post("/menu/get", 'Admin\WeixinController@get_menu');
    Route::post("/menu/set", 'Admin\WeixinController@set_menu');

    Route::get('/group/get', 'Admin\WeixinController@get_wx_group');
    Route::get('/group/set', 'Admin\WeixinController@set_wx_group');
    Route::get('/group/move', 'Admin\WeixinController@move_wx_group');
    Route::get('/group/del', 'Admin\WeixinController@del_wx_group');
    Route::get('/group/menu/a/set', 'Admin\WeixinController@set_wx_group_menu_a');
    Route::get('/group/menu/b/set', 'Admin\WeixinController@set_wx_group_menu_b');
    Route::get('/menu/get', 'Admin\WeixinController@get_wx_menu');
    Route::get('/user/menu/get', 'Admin\WeixinController@get_wx_user_mennu');
});*/
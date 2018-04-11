<template>
    <div class="gm-header">
        <div class="title">
            {{ app_name }}
        </div>
         <!-- <ul class="gm-sys">
          <li><a href="#">掌上通知</a></li>
          <li><a href="#">伽马教育</a></li>
          <li><a href="#">伽马直播</a></li>
        </ul> -->
        <el-menu default-active="1" class="el-menu-cls header_menu" :router=false mode="horizontal" @select='handleSelect'>
            <el-submenu index="user">
                <template slot="title">个人中心</template>
                <el-menu-item index="/super/password" class="resetPassWord">修改密码</el-menu-item>
                <!-- <el-menu-item index="/user/sign">签名</el-menu-item> -->
            </el-submenu>
            <el-menu-item index='logout'>
                退出系统
            </el-menu-item>
        </el-menu>
        <div style="clear:both;"></div>
    </div>
</template>
<style>
    .header_menu > .is-active{
        color: #248CF7 !important;
    }

    .resetPassWord:hover{
        color: #409EFF;
    }
    .gm-header > ul {
        background-color: transparent !important;
    }

    .gm-header > ul > li, .gm-header .el-submenu__title ,.gm-header .el-submenu__title i{
        color: white  !important;
    }

    .gm-header > ul, .gm-header > ul > li, .gm-header .el-submenu__title:hover {
        background-color: transparent !important;
    }

    .gm-header .el-submenu__title:hover,.gm-header > ul > li:hover{
        color: #BAD5F1 !important;
    }

    .gm-header {
        background-color: #409EFF;
        height: 60px;
    }

    .gm-header .title {
        float: left;
        margin: 0 30px;
        line-height: 60px;
        font-size: 24px;
        color: #fff;
    }

    .gm-header .el-menu {
        float: right;
        margin-right: 20px;
    }

</style>
<script>
    export default{
        data() {
            return {
                app_name: window.GammaApp.appName,
                app_name: '微印商城',
            }
        },
        methods: {
            handleSelect(key, keyPath){
                if (key == 'logout') {
                   window.location.href="/logout";

                } else {
                    // console.log(key, keyPath)
                    this.$router.push(key);
                }
            }
        }
    }
</script>

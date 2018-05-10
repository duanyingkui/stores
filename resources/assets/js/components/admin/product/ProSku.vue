<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>产品管理</el-breadcrumb-item>
                <el-breadcrumb-item>产品sku管理</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-form :label-position="labelPosition" :inline="true" :model="pro_sku" class="demo-form-inline">       
            <el-form-item>
                <el-button size="small"><i class="ion-plus"></i> 添加SKU属性</el-button>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" size="small" @click="save_sku">更新SKU属性</el-button>
            </el-form-item>
            <el-form-item label="属性名称">
                <el-input v-model="pro_sku.name" size="small" placeholder="输入sku名称"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button style="margin-right:-12px" type="primary" size="small" @click="getData">查询</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                pro_sku : {
                    name : ''
                },
                labelPosition : "left",
            }
        },
        methods : {
            save_sku(){

            },
            getData(){

            }
        },
        mounted(){

        }
    }
</script>

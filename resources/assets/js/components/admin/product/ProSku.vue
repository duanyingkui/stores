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
        <el-table
            v-loading="loading"
                :data="tableData"
                border
                fit
                style="width: 100%; margin-top:10px;">
            <el-table-column
                    label="ID">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="属性名称">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.name }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="属性值">
                <template slot-scope="scope">                   
                    {{ scope.row.item }}
                </template>
            </el-table-column>
            <el-table-column
                    label="操作">
                <template slot-scope="scope">
                    <el-button @click="remove_sku(scope.row.id)" size="small" icon="edit">移除此SKU</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination
            @size-change="onPageSizeChange"
            @current-change="onPageChange"
            :current-page="page"
            :page-sizes="[10, 20, 50, 100]"
            :page-size="pageSize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total">
        </el-pagination>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                id : Number.parseInt(this.$route.query.id),
                loading: false,
                tableData: [],
                itemData: [],
                page : 1,
                pageSize : 10,
                total : 0,
                pagination: {
                    current: 1,
                    pagesize: 50
                },
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
                var self = this;
                var query = {
                    page     : self.page,
                    pageSize : self.pageSize,
                    pro_sku  : self.pro_sku,
                    id       : self.id,
                };
                axios.get('/admin/product/product_sku_paginate',{params:query}).then(function(res){
                    self.loading = false;
                    var data = res.data.msg;
                    console.log(data);
                    self.total = data.total;
                    self.tableData = data.product_sku;      
                })
            },
            onPageChange(val){
                this.page = val;
                this.getData();
            },
            onPageSizeChange(val){
                this.pagination.pagesize=val;
                this.pageSize = val;
                this.getData();
            },
            SkuEdit(id){

            },
        },
        mounted(){
            if (this.id > 0) {
                this.getData();
                this.loading = true;
            }
        }
    }
</script>

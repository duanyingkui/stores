<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>产品管理</el-breadcrumb-item>
                <el-breadcrumb-item>产品列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-form :label-position="labelPosition" :inline="true" :model="selt_product" class="demo-form-inline">       
            <el-form-item>
                <router-link to="/product/edit">
                    <el-button size="small"><i class="ion-plus"></i> 添加项目</el-button>
                </router-link>
            </el-form-item>
            <el-form-item label="商品名称">
                <el-input v-model="selt_product.name" size="small" placeholder="输入商品名称"></el-input>
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
                    label="商品ID">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.id }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="商品名称">
                <template slot-scope="scope">
                    <span style="margin-left: 10px">{{ scope.row.product_name }}</span>
                </template>
            </el-table-column>
            <el-table-column
                    label="商品单位">
                <template slot-scope="scope">                   
                    {{ scope.row.unit_id }}
                </template>
            </el-table-column>
            <!-- <el-table-column
                    label="商品单价">
                <template slot-scope="scope">
                    {{ scope.row.price }}
                </template>
            </el-table-column> -->
            <el-table-column
                    label="SKU管理">
                <template slot-scope="scope">
                    <el-button @click="SkuEdit(scope.row.id)" size="small" icon="edit">管理</el-button>
                </template>
            </el-table-column>
            <el-table-column label="操作">
                <template slot-scope="scope">
                    <el-button @click="handleEdit(scope.row.id)" size="mini" icon="edit">立即下单</el-button>
                    <el-button @click="handleEdit(scope.row.id)" size="mini" icon="edit">编辑</el-button>
                    <el-button @click="handleDelete(scope.row.id)" size="mini" icon="delete">删除</el-button>
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
                loading: false,
                tableData: [],
                page : 1,
                pageSize : 10,
                total : 0,
                pagination: {
                    current: 1,
                    pagesize: 50
                },
                selt_product : {
                    name : ''
                },
                labelPosition : "left",
            }
        },
         methods: {
            getData(){
                var self = this;
                var query = {
                    page : this.page,
                    pageSize : this.pageSize,
                    selt_product : this.selt_product,
                };
               axios.get('/admin/product/get_product_list_paginate',{params:query}).then(function(res){
                    self.loading = false;
                    var data = res.data.msg;
                    self.total = data.total;
                    self.tableData = data.product;               
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
            handleEdit(id) {
                this.$router.push(`/product/edit?id=${id}`);
            },
            handleDelete(id) {
                var self = this;
                this.$confirm('确认删除？','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(function(){
                   self.$http.post('/admin/product/delete',{id:id}).then(function(res){
                       var data = res.data;
                       data.code==0? self.getData() : '';
                       var title = data.code==0 ? '成功' : '失败';
                       var type = data.code ==0 ? 'success' : 'warning';
                       this.$notify({
                           title: title,
                           message: data.msg,
                           type: type
                       });
                   })
                }).catch(function(){})
            },
        },
        mounted(){
            this.getData();
            this.loading = true;
        }
    }
</script>

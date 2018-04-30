<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>订单管理</el-breadcrumb-item>
                <el-breadcrumb-item>文件列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <template>
            <el-table
                    :span-method="arraySpanMethod"
                    :data="tableData"
                    stripe
                    style="width: 100%">
                <el-table-column
                        type="index"
                        width="50">
                </el-table-column>
                <el-table-column
                        prop="file_name"
                        label="文件名"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="order_number"
                        label="订单编号"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="创建时间">
                </el-table-column>
                <el-table-column
                        label="操作"
                        width="200">
                    <template slot-scope="scope">
                        <el-button @click="handleClick(scope.row)" size="small" type="primary">下载</el-button>
                        <el-button size="small" type="danger">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination
                    @size-change="onPageSizeChange"
                    @current-change="onPageChange"
                    :current-page="page"
                    :page-sizes="[5, 10, 20, 50, 100]"
                    :page-size="pageSize"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="total">
            </el-pagination>
        </template>
    </div>
</template>
<script>
    export default{
        data() {
            return{
                tableData: [],
                page     : 1,
                pageSize : 5,
                total    : 0,
            }
        },
        methods : {
            arraySpanMethod({ row, column, rowIndex, columnIndex }) {
                if (columnIndex === 0) {
                    if (rowIndex % 2 === 0) {
                        return {
                            rowspan: 2,
                            colspan: 1
                        };
                    } else {
                        return {
                            rowspan: 0,
                            colspan: 0
                        };
                    }
                }
            },
            //分页，每页显示多少条记录
            onPageSizeChange(val){
                this.pageSize = val ;
                this.getData();
            },
            //分页
            onPageChange(val){
                this.page = val;
                this.getData();
            },
            handleClick(row) {
                console.log(row);
            },
            getData(){
                var self = this
                let params = {
                    pageSize    : self.pageSize,
                    page        : self.page
                }
                axios.get('/admin/order/getFiles',{params:params}).then(function (res) {
                    var data = res.data;
                    if(data.code == 0){
                        console.log(data.result);
                        self.handlingData(data.result.data);
                        self.tableData = data.result.data;
                        self.total     = data.result.total;
                    }else{
                        self.$message({
                            type: 'error',
                            message: data.msg
                        })
                    }
                }, function (err) {
                    console.log(err);
                })
            },
            handlingData(data){
                var map = new Map();
                var order_number = '';
                var count = 0,index = 0;
                data.forEach(function (value) {
                    if(order_number != value.order_number){
                        order_number = value.order_number;
                        count = 1;
                    }else{
                        //TODO::
                    }
                });
            }
        },
        mounted(){
            this.getData();
        }
    }
</script>

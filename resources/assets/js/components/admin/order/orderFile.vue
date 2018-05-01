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
        <el-form :inline="true" class="demo-form-inline">
            <el-form-item >
                <el-button class="button" @click="deleteFiles" type="danger"><i class="icon ion-trash-a"></i>&nbsp;批量删除</el-button>
            </el-form-item>
            <el-form-item>
                <el-input id="input" placeholder="请输入订单编号" v-model.trim="queryData" clearable></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" class="button" @click="getData"><i class="icon ion-search"></i>&nbsp;查询</el-button>
            </el-form-item>
        </el-form>
        <template>
            <el-table
                    :span-method="arraySpanMethod"
                    :data="tableData"
                    @selection-change="handleSelectionChange"
                    style="width: 100%">
                <el-table-column type="selection" width="55">
                </el-table-column>
                <el-table-column
                        prop="order_number"
                        label="订单编号"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="file_name"
                        label="文件名"
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
                        <el-button @click="deleteFile(scope.row)" size="small" type="danger">删除</el-button>
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
                tableData   : [],
                tableMerge  : {},
                page        : 1,
                pageSize    : 10,
                total       : 0,
                multipleSelection: [],
                queryData   : '',
            }
        },
        methods : {
            handleSelectionChange(val) {
                let self = this;
                self.multipleSelection = [];
                val.forEach(function (value) {
                    if(self.multipleSelection.indexOf(value.order_id) < 0)
                        self.multipleSelection.push(value.order_id);
                });
            },
            arraySpanMethod({ row, column, rowIndex, columnIndex }) {
                if (columnIndex === 0 || columnIndex === 1) {
                    if (this.tableMerge.has(rowIndex)) {
                        return {
                            rowspan: this.tableMerge.get(rowIndex),
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
                    page        : self.page,
                    queryData   : self.queryData
                };
                console.log(self.queryData);
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
            deleteFile(row){
                var self = this;
                var id = row.id,order_id = row.order_id,file_name = row.file_path;
                axios.post('/admin/order/deleteFile',{fileId:id,orderId:order_id,fileName:file_name}).then(function (res) {
                    var data = res.data;
                    if(data.code == 0){
                        self.$message({
                            type: 'success',
                            message: data.msg
                        });
                        self.getData();
                    }else{
                        self.$message({
                            type: 'error',
                            message: data.msg
                        });
                    }
                }, function (err) {
                    console.log(err);
                })
            },
            deleteFiles(){
                if(this.multipleSelection.length === 0){
                    this.$message({
                        message: '请选择先文件'
                    });
                    return;
                }
                let self = this;
                let fileNames = [];
                self.tableData.forEach(function (value) {
                    if(self.multipleSelection.indexOf(value.order_id) >= 0)
                        fileNames.push(value.file_path);
                });
                axios.post('/admin/order/deleteFiles',{orderIds:self.multipleSelection,fileNames:fileNames}).then(function (res) {
                    var data = res.data;
                    if(data.code == 0){
                        self.$message({
                            type: 'success',
                            message: data.msg
                        });
                        self.getData();
                    }else{
                        self.$message({
                            type: 'error',
                            message: data.msg
                        });
                    }
                }, function (err) {
                    console.log(err);
                })
            },
            handlingData(data){
                var map = new Map();
                var order_number = '';
                var gIndex = 0,index = 0,count;
                data.forEach(function (value) {
                    if(order_number != value.order_number){
                        order_number = value.order_number;
                        count = 1;
                        index = gIndex;
                    }else{
                        count++;
                    }
                    map.set(index,count);
                    gIndex++;
                });
                this.tableMerge = map;
            }
        },
        mounted(){
            this.getData();
        }
    }
</script>

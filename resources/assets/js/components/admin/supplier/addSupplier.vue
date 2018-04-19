<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>供应商管理</el-breadcrumb-item>
                <el-breadcrumb-item>供应商列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
            <div>
                <el-button type="primary" @click="addSupplier"><i class="el-icon-plus"></i> 添加供应商</el-button>
                <el-button type="primary" icon="el-icon-delete" style="margin-right: 20px;">批量删除</el-button>
                <el-input v-model="input" placeholder="请输入查询内容" style="width: 40%"></el-input>
                <el-button type="primary" icon="el-icon-search">搜索</el-button>
                <el-button type="primary" style="float: right">导出表格</el-button>
                <el-button type="primary"  style="float: right">导入表格</el-button>
            </div>
        <div style="margin-top: 20px;">
            <el-table :data="tableData"  stripe style="width: 100%">
                <el-table-column width="50">
                    <template slot-scope="scope" width="100">
                        <el-checkbox-group v-model="checkList">
                            <el-checkbox label=""></el-checkbox>
                        </el-checkbox-group>
                    </template>
                </el-table-column>
                <el-table-column prop="date" label="ID" width="110"></el-table-column>
                <el-table-column prop="name" label="供应商姓名" width="140" sortable></el-table-column>
                <el-table-column prop="address" label="联系电话" sortable></el-table-column>
                <el-table-column prop="address" label="供应商品类型" sortable></el-table-column>
                <el-table-column prop="address" label="供应商地址" sortable></el-table-column>
                <el-table-column prop="address" label="创建时间" sortable></el-table-column>
                <el-table-column prop="address" label="操作">
                    <template slot-scope="scope" width="60">
                        <el-button size="small" type="primary" icon="el-icon-edit"></el-button>
                        <el-button size="small" type="danger"  icon="el-icon-delete"></el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination background layout="prev, pager, next" :total="1000" style="margin-top: 30px;"></el-pagination>

            <el-dialog title="添加供应商" :visible.sync="onaddSupplier">
                <el-form :model="form">
                    <el-form-item label="供应商名称" :label-width="formLabelWidth">
                        <el-input v-model="form.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="联系方式" :label-width="formLabelWidth">
                        <el-input v-model="form.name" auto-complete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="供应类型" :label-width="formLabelWidth">
                        <el-select v-model="form.region" placeholder="请选择活动区域">
                            <el-option label="区域一" value="shanghai"></el-option>
                            <el-option label="区域二" value="beijing"></el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="addSupplier = false">取 消</el-button>
                    <el-button type="primary" @click="addSupplier = false">确 定</el-button>
                </div>
            </el-dialog>
        </div>
    </div>
</template>

<script>
    import ElInput from "../../../../../../node_modules/element-ui/packages/input/src/input";
    import ElDialog from "../../../../../../node_modules/element-ui/packages/dialog/src/component";
    export default{
        components: {
            ElDialog,
            ElInput},
        data() {
            return {
                input:'',
                checkList:'',
                tableData: [{
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                }, {
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                }],
                onaddSupplier: false,
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''
                },
                formLabelWidth: '120px'
            }
        },
        methods : {
            addSupplier(){
                this.form.name          = '';
                this.form.linkman       = '';
                this.form.phone         = '';
                this.form.address       = '';
                this.onaddSupplier  = true
            },
        },
        mounted(){

        },

    }
</script>

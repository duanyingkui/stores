<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item> 客户管理</el-breadcrumb-item>
                <el-breadcrumb-item>客户列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-form :inline="true" class="demo-form-inline">
          <el-form-item >
            <el-button class="button" @click="onAddClick"><i class="icon ion-plus-round" ></i>&nbsp;添加客户</el-button>
          </el-form-item>
           <el-form-item >
            <el-button class="button"><i class="icon ion-trash-a"></i>&nbsp;批量删除</el-button>
          </el-form-item>
          <el-form-item>
            <el-input id="input" placeholder="请输入查询内容" v-model="input10" clearable></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" class="button" @click="onSubmit"><i class="icon ion-search"></i>&nbsp;查询</el-button>
          </el-form-item>
        </el-form>

        <template>
          <el-table :data="tableData"  stripe style="width: 100%">
                <el-table-column width="50">
                     <template slot-scope="scope" width="100">
                        <el-checkbox-group v-model="checkList">
                            <el-checkbox label=""></el-checkbox>
                        </el-checkbox-group>
                  </template>
                </el-table-column>
                <el-table-column  type="index" width="80"></el-table-column>
                <el-table-column prop="name" label="客户方" width="100" sortable></el-table-column>
                <el-table-column prop="linkman" label="订单人" width="100" sortable></el-table-column>
                <el-table-column prop="address_name" label="默认收货地址" width="180" sortable></el-table-column>
                <el-table-column prop="phone" label="联系电话" width="130" sortable></el-table-column>
                <el-table-column prop="created_at" label="创建时间" width="180" sortable></el-table-column>
                <el-table-column label="操作">
                  <template slot-scope="scope" width="60">
                        <el-button size="small" type="primary" icon="el-icon-edit"   @click="handleEdit(scope.row.id)"></el-button>
                        <el-button size="small" type="danger"  icon="el-icon-delete" @click="handleEdit(scope.row.id)"></el-button> 
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
        <el-dialog title="详情" :visible.sync="dialogFormVisible">
            <el-form :model="form" :rules="rules" ref="form" v-loading="formLading">
                <el-form-item label="客户方" prop="name">
                    <el-input
                        v-model="form.name"
                        placeholder="请输入客户方">
                    </el-input>
                </el-form-item>
                <el-form-item label="联系人" prop="linkman">
                    <el-input
                        v-model="form.linkman"
                        placeholder="请输入联系人">
                    </el-input>
                </el-form-item>
                 <el-form-item label="联系方式" prop="phone">
                    <el-input
                        v-model="form.phone"
                        placeholder="请输入联系方式">
                    </el-input>
                </el-form-item>
                <el-form-item label="请选择收货地区(此地址将作为默认收货地址)" prop="addressArea">
                    <div style="display: block">
                        <el-cascader 
                        size="large"
                        :options="options"
                        v-model="form.code"
                        @change="testAddress"
                        > 
                        </el-cascader>
                    </div>
                </el-form-item>
                <el-form-item label="详细地址" prop="address">
                    <el-input
                        v-model="form.address"
                        placeholder="请输入详细地址">
                    </el-input>
                </el-form-item>
            </el-form>

            <div  slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" :loading="saving"  @click="handleSave('form')">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<style>
    .button{
        border-color: #72c1e4;
        font-size: 12px;
        height: 35px;   
    }
    #input{
        border-color: #72c1e4;
        font-size: 12px;
        height: 35px; 
    }
</style>  

<script>
    import {regionData,CodeToText} from 'element-china-area-data'
    export default{
        data(){
            return {
                tableData   : [],
                input10     : '',
                checked     : true,
                checkList   : [],
                page        : 1,
                pageSize    : 5,
                total       : 0,
                dialogFormVisible: false,
                formLading  : false,
                saving      : false,
                form:{
                    name    : '',
                    linkman : '',
                    phone   : '',
                    code    : [],
                    address : '',
                },
                addressKey: null,
                addresses:[],
                rules: {
                    name    : [
                        { required: true, message: '请输入名称', trigger: 'blur' },
                        { min: 3, max: 15, message: '长度在 3 到 15 个字符', trigger: 'blur' }
                    ],
                    linkman : [
                        { required: true, message: '请输入名称' },
                        { min: 3, max: 15, message: '长度在 3 到 15 个字符' }
                    ],
                    phone   : [
                        { required: true, message: '请输入名称' },
                        { min: 11, max: 11, message: '长度为11个字符' }
                    ],
                    address : [
                        { required: true, message: '请输入名称' },
                        { min: 3, max: 15, message: '长度在 3 到 15 个字符' }
                    ],  
                },
                options    : regionData,
            }
        },
        methods : {
            testAddress(value){
                console.log(value)
                console.log(CodeToText[value[0]])
                console.log(CodeToText[value[1]])
                console.log(CodeToText[value[2]])
            },
            onSubmit() {
                console.log('subwwwmit!');
            },

            /*
                获取客户信息
            */

            getCustomer(){               
                let self = this;
                let params = {
                    pageSize : self.pageSize,
                    page : self.page
                }

                axios.get('admin/customer/list',{params:params}).then(res => {
                    self.tableData = res.data.customer.data;
                    self.total = res.data.customer.total;                    
                }).catch(err => {
                    console.log(err);
                })
            },

            /*
                展示添加客户对话框
            */

            onAddClick(){
                
                this.form.name          = '';
                this.form.linkman       = '';
                this.form.phone         = '';
                this.form.address       = '';
                this.dialogFormVisible  = true
            },

            /*
            客户信息验证规则
            */

            test(){
                var phone1   = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/;
                var mobile   = /\d{3}-\d{8}|\d{4}-\d{7}/;
                var text = /^[\u4E00-\u9FA5A-Za-z0-9]{3,20}$/;

                if(!phone1.test(this.form.phone) && !mobile.test(this.form.phone)){
                    this.$message.error("手机号错误");
                }else if(!text.test(this.form.name)){
                    this.$message.error("客户方名称应是在3-20之间的中文、英文、数字，但不包括下划线等符号");
                }else if(!text.test(this.form.address)){
                    this.$message.error("地址名称应是在3-20之间的中文、英文、数字，但不包括下划线等符号");
                }
                else{
                    return true;
                }
                return false;
            },

            /*
                保存新添加的客户信息
            */
            
            handleSave(form){
                this.$refs[form].validate((valid)=>{
                    let self = this;
                    if(self.test()){
                        axios.post('admin/customer/list/add',self.form).then(res => {
                            console.log(res);
                            let data = res.data;
                            if(data.code == 0){
                                self.getCustomer();
                                self.$message.success("添加客户成功！");
                                self.dialogFormVisible = false;
                            }else{
                                this.$message.error(data.msg);
                            }
                            this.saving = false ;
                        }).catch(err => {
                            console.log(err);
                        })
                    }

                    
                    // self.form.detailAddress = '';
                    // self.form.code.forEach(function(value){
                    //     self.form.detailAddress += CodeToText[value];
                    // });
                    // self.form.detailAddress += self.form.address;

                    // console.log(self.form.detailAddress);

                    // if(valid){
                    //     this.saving = true;
                    //     axios.post("admin/customer/list/add",this.form).then(res=>{
                    //         // console.log(res);
                    //        let data = res.data;
                    //        if(data.code == 0){
                    //             this.getCustomer();
                    //             this.$message.success(data.msg);
                    //             this.dialogFormVisible = false;
                    //        } else {
                    //             this.$message.error(data.msg);
                    //        }
                    //        this.saving = false ;
                    //     })
                    // }

                });
            },

            /*
                修改客户信息
            */
            handleEdit(id){
                console.log(id);
                let self = this;
                axios.get("admin/customer/list/get",id).then(res => {
                    console.log(res);
                }).catch(err=>{
                    console.log(err);
                });
            },

            /*
                分页，每页显示多少条记录
            */
            onPageSizeChange(val){
                this.pageSize = val ;
                this.getCustomer();
            },


            /*
                分页
            */
            onPageChange(val){
                this.page = val;
                this.getCustomer();
            }            
        },
        mounted: function () {
            this.$nextTick(function () {
            // 代码保证 this.$el 在 document 中
                this.getCustomer();
            })
        }
    }

</script>

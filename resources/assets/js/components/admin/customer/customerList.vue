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
            <el-button class="button" @click="deleteCustomers"><i class="icon ion-trash-a"></i>&nbsp;批量删除</el-button>
          </el-form-item>
          <el-form-item>
            <el-input id="input" placeholder="请输入查询内容" v-model="queryData" clearable></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" class="button" @click="getCustomer"><i class="icon ion-search"></i>&nbsp;查询</el-button>
          </el-form-item>
        </el-form>

        <template>
          <el-table :data="tableData"  stripe style="width: 100%" @selection-change="handleSelectionChange">
                <!-- <el-table-column width="50">
                     <template slot-scope="scope" width="100">
                        <el-checkbox-group v-model="checkList">
                            <el-checkbox></el-checkbox>
                        </el-checkbox-group>
                  </template>
                </el-table-column> -->
                <el-table-column type="selection" width="55"></el-table-column>
                <el-table-column  type="index" :xs="8" :sm="6" :md="4" :lg="3" :xl="1"></el-table-column>
                <el-table-column prop="name" label="客户方" :xs="8" :sm="6" :md="4" :lg="3" :xl="1" sortable></el-table-column>
                <el-table-column prop="linkman" label="订单人" :xs="6" :sm="4" :md="3" :lg="2" :xl="1" sortable></el-table-column>
                <el-table-column prop="address_name" label="默认收货地址" :xs="8" :sm="6" :md="4" :lg="3" :xl="1" sortable></el-table-column>
                <el-table-column prop="phone" label="联系电话" :xs="8" :sm="6" :md="4" :lg="3" :xl="1" sortable></el-table-column>
                <el-table-column prop="created_at" label="创建时间" :xs="8" :sm="6" :md="4" :lg="3" :xl="1" sortable></el-table-column>
                <el-table-column label="操作">
                  <template slot-scope="scope" :xs="8" :sm="6" :md="4" :lg="3" :xl="1">
                        <el-button size="small" type="primary" icon="el-icon-edit"   @click="handleEdit(scope.row.id)"></el-button>
                        <el-button size="small" type="danger"  icon="el-icon-delete" @click="deleteCustomer(scope.row.id,scope.row.phone)"></el-button> 
                  </template>
                </el-table-column>
            </el-table>

            <el-pagination
                @size-change="onPageSizeChange"
                @current-change="onPageChange"
                :current-page="page"
                page-sizes:="[5, 10, 20, 50, 100]"
                :page-size="pageSize"
                layout="total, sizes, prev, pager, next, jumper"
                :total="total">
            </el-pagination>
        </template>

        <el-dialog title="添加客户" :visible.sync="dialogFormVisible">
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

        <el-dialog title="修改客户信息" :visible.sync="editDialogVisible">
            <el-form :model="form" :rules="rules" ref="form" v-loading="formLading">
                <el-form-item label="客户方" prop="name">
                    <el-input
                            v-model="editForm.name"
                            placeholder="请输入联系人">
                    </el-input>
                </el-form-item>
                <el-form-item label="联系人" prop="linkman">
                    <el-input
                            v-model="editForm.linkman"
                            placeholder="请输入联系人">
                    </el-input>
                </el-form-item>
                <el-form-item label="联系方式" prop="phone">
                    <el-input
                            v-model="editForm.phone"
                            placeholder="请输入联系方式">
                    </el-input>
                </el-form-item>
                <el-form-item label="请选择收货地区(此地址将作为默认收货地址)" prop="addressArea">
                    <div style="display: block">
                        <el-cascader
                                size="large"
                                :options="options"
                                v-model="editForm.code"
                                @change="testAddress"
                        >
                        {{editForm.detailedAddress}}
                        </el-cascader>
                    </div>
                </el-form-item>
                <el-form-item label="详细地址" prop="address">
                    <el-input
                            v-model="editForm.address"
                            placeholder="请输入详细地址">
                    </el-input>
                </el-form-item>
            </el-form>

            <div  slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" :loading="saving"  @click="handleSave('form')">确定修改</el-button>
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
                queryData   : '',
                checked     : true,
                multipleSelection   : [],
                multipleSelection2  : [],
                page        : 1,
                pageSize    : 5,
                total       : 0,
                saving      : false,
                formLading  : false,
                dialogFormVisible   : false,
                editDialogVisible   : false,
                form:{
                    name    : '',
                    linkman : '',
                    phone   : '',
                    code    : [],
                    address : '',
                },
                editForm:{
                    name    : '',
                    linkman : '',
                    phone   : '',
                    code    : [],
                    address : '',
                    detailedAddress : '',
                },
                addressKey  : null,
                addresses   :[],
                rules: {
                    name    : [
                        { required: true, message: '请输入名称', trigger: 'blur' },
                        { min: 2, max: 15, message: '长度在 3 到 15 个字符', trigger: 'blur' }
                    ],
                    linkman : [
                        { required: true, message: '请输入名称' },
                        { min: 2, max: 15, message: '长度在 3 到 15 个字符' }
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
//                console.log(value)
//                console.log(CodeToText[value[0]])
//                console.log(CodeToText[value[1]])
//                console.log(CodeToText[value[2]])
            },
            onSubmit() {
                console.log(this.queryData);
            },
            //获取客户信息
            getCustomer(){               
                let self = this;
                let params = {
                    pageSize    : self.pageSize,
                    page        : self.page,
                    queryData   : self.queryData,
                }
                axios.get('admin/customer/list',{params:params}).then(res => {
                    self.tableData  = res.data.customer.data;
                    self.total      = res.data.customer.total;                    
                }).catch(err => {
                    console.log(err);
                })
            },
            //展示添加客户对话框
            onAddClick(){
                
                this.form.name          = '';
                this.form.linkman       = '';
                this.form.phone         = '';
                this.form.address       = '';
                this.dialogFormVisible  = true
            },
            //客户信息验证规则
            test(){
                var phone1  = /^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/;
                var mobile  = /\d{3}-\d{8}|\d{4}-\d{7}/;
                var text    = /^[\u4E00-\u9FA5A-Za-z0-9]{3,20}$/;
                if(!phone1.test(this.form.phone) && !mobile.test(this.form.phone)){
                    this.$message.error("手机号错误");
                }else if(!text.test(this.form.name)){
                    this.$message.error("客户方名称应是在3-20之间的中文、英文、数字，但不包括下划线等符号");
                }else if(!text.test(this.form.address)){
                    this.$message.error("地址名称应是在3-20之间的中文、英文、数字，但不包括下划线等符号");
                }else{
                    return true;
                }
                return false;
            },
            //添加客户信息
            handleSave(form){
                this.$refs[form].validate((valid)=>{
                    let self = this;
                    if(self.test()){
                        axios.post('admin/customer/list/add',self.form).then(res => {
                            let data = res.data.addCustomer.original;
                            console.log(res)
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
                });
            },
            //修改客户信息
            handleEdit(id){
                let params = {
                    id:id
                }
                let self = this;
                
                axios.get("admin/customer/list/get",{params:params}).then(res => {
                    console.log(res.data);
                    var data = res.data;
                    console.log(data.address[0]['address_name']);
                    console.log(data.customer.id);
                    self.editForm.name      =   data.customer.name;
                    self.editForm.linkman   =   data.customer.linkman;
                    self.editForm.phone     =   data.customer.phone;
                    self.editForm.address   =   data.address[0]['address_name'];
                    var codes = data.address[0]['code'].split('/')
                    var address = ''
                    codes.forEach(function (value) {
                        address += CodeToText[value] 
                    })
                    // self.editForm.detailedAddress = address
                    console.log(self.editForm.detailedAddress)
                    self.editDialogVisible  =   true;
                }).catch(err=>{
                    console.log(err);
                });
            },
            //删除客户信息
            deleteCustomer(id , phone){
                let self = this;
                let params = {
                    id    : id,
                    phone : phone,
                }
                self.$confirm('此客户信息将要被删除，确定吗？','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(()=>{
                    axios.get("admin/customer/list/delete",{params:params}).then(res => {
                        var data = res.data.delCustomer.original;
                        if (data.code == 0) {
                            self.$message.success("删除成功");
                            self.getCustomer();
                        }else{
                            self.$message.error("删除失败");
                            self.getCustomer();
                        }
                    })
                })
            },
            handleSelectionChange(val) {
                var self = this;
                self.multipleSelection = [];
                self.multipleSelection2= [];
                console.log(val);
                val.forEach(function(value){
                    self.multipleSelection.push(value.id);
                    self.multipleSelection2.push(value.phone);
                });
            },
            //删除多条记录
            deleteCustomers(){
                if(this.multipleSelectionId.length == 0){
                    self.$message.warning("没有行被选中!");
                };
                let self = this;
                let params = {
                    customerIds : self.multipleSelection,
                    customerPhones : self.multipleSelection2
                }
                self.$confirm('确认删除选中的'+self.multipleSelectionId.length+'条客户信息吗？','提示',{
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(()=>{
                    axios.post("admin/customer/list/deleteCustomers",params).then(res => {
                        console.log(res.data);
                        var data = res.data;
                        if (data.code == 1) {
                            self.$message.success("删除成功");
                            self.getCustomer();
                        }else{
                            self.$message.error(data.msg);
                        }
                    })
                })
            },
            //分页，每页显示多少条记录
            onPageSizeChange(val){
                this.pageSize = val ;
                this.getCustomer();
            },
            //分页
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
<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item>订单管理</el-breadcrumb-item>
                <el-breadcrumb-item>新增订单</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-form :model="ruleForm" ref="ruleForm" label-width="100px" class="demo-ruleForm">
            <el-form-item label="客户名称：" prop="customer_name">
                <el-row>
                    <el-col :span="10">
                        <el-autocomplete style="display: block"
                                v-model="ruleForm.customer_name"
                                :fetch-suggestions="customQuerySearch"
                                placeholder="请输入内容"
                                @select="customHandleSelect"
                        ></el-autocomplete>
                    </el-col>
                    <span v-bind:class="{ status : customerStatus }" style="color: red;margin-left: 10px">客户不存在</span>
                </el-row>
            </el-form-item>
            <el-form-item label="收货人：">
                <el-row>
                    <el-col :span="10">
                        {{ default_address.consignee }}
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="联系方式：">
                <el-row>
                    <el-col :span="10">
                        {{ default_address.consignee_mobile }}
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="收货地址：">
                <el-row>
                    <el-col :span="10">
                        {{ default_address.detailedAddress }}
                    </el-col>
                    <el-button @click="loadAddresses">默认收货信息</el-button>
                </el-row>
            </el-form-item>
            <hr>
            <el-form-item label="产品名称：" prop="product_name">
                <el-row>
                    <el-col :span="10">
                        <el-autocomplete style="display: block"
                                 v-model="ruleForm.product_name"
                                 :fetch-suggestions="productQuerySearch"
                                 placeholder="请输入内容"
                                 @select="productHandleSelect"
                        ></el-autocomplete>
                    </el-col>
                    <span v-bind:class="{ status : productStatus }" style="color: red;margin-left: 10px">产品不存在</span>
                </el-row>
            </el-form-item>
            <el-form-item label="产品规格：" prop="item_ids">
                <el-row v-for="(sku,sku_key) in skus" :key="sku.id">
                    <el-col>
                        <span style="display: block;">{{ sku.name }}</span>
                        <el-radio-group v-model="skus[sku_key].select" :disabled="ruleForm.show_user_defined" size="small">
                            <el-radio v-for="item in sku.items"
                                :key="item.item_id"
                                :label="item.item_id" border>
                                {{ item.name }}
                            </el-radio>
                        </el-radio-group>
                    </el-col>
                </el-row>
                <el-tag style="margin-top: 10px" :type="defined_type" ><span style="padding: 5px 12px;cursor: pointer;" @click="tagClick()">自定义</span></el-tag>
            </el-form-item>
            <el-form-item label="" prop="user_defined" v-if="ruleForm.show_user_defined">
                <el-row>
                    <el-col :span="10">
                        <el-input
                                type="textarea"
                                :maxlength="300"
                                :autosize="{ minRows: 4}"
                                placeholder="请输入自定义内容(最大长度300)"
                                v-model="ruleForm.user_defined">
                        </el-input>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="上传文件：">
                <el-row>
                    <el-col :span="10">
                        <el-upload
                                class="upload-demo"
                                drag
                                action="admin/order/upload"
                                :on-preview="handlePreview"
                                :on-remove="handleRemove"
                                :before-remove="beforeRemove"
                                :before-upload="beforeImgUpload"
                                :on-error="error"
                                :data="csrf_token"
                                accept=".png,.jpg,.jpeg,.rar,.zip"
                                multiple
                                :limit="3"
                                :on-exceed="handleExceed"
                                :file-list="fileList">
                            <i class="el-icon-upload"></i>
                            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                            <div class="el-upload__tip" slot="tip">只能上传jpg/png/zip/rar文件，且不超过10M，超过三个文件请将之放在一个文件中压缩后上传</div>
                        </el-upload>
                    </el-col>
                </el-row>
            </el-form-item>
            <hr>
            <el-form-item label="应当付款：" prop="should_pay">
                <el-row>
                    <el-col :span="10">
                        <el-input placeholder="请输入内容" v-model="ruleForm.should_pay" clearable>
                            <template slot="append">元</template>
                        </el-input>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="实际付款：" prop="fact_pay">
                <el-row>
                    <el-col :span="10">
                        <el-input placeholder="请输入内容" v-model="ruleForm.fact_pay" clearable>
                            <template slot="append">元</template>
                        </el-input>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="付款方式：" prop="pay_way_id">
                <el-row>
                    <el-col :span="10">
                        <el-select v-model="ruleForm.pay_way_id" clearable placeholder="请选择">
                            <el-option
                                    v-for="item in pay_way"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item label="交货方式：" prop="delivery_way_id">
                <el-row>
                    <el-col :span="10">
                        <el-select v-model="ruleForm.delivery_way_id" clearable placeholder="请选择">
                            <el-option
                                    v-for="item in delivery_way"
                                    :key="item.id"
                                    :label="item.name"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-col>
                </el-row>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm()">立即添加</el-button>
                <el-button @click="resetForm('ruleForm')">重置</el-button>
            </el-form-item>
        </el-form>

        <el-dialog title="收货地址" :visible.sync="dialogFormVisible">
            <el-form>
                <el-form-item v-for="(value, key) in addresses" :key="value.id">
                    <el-card>
                        <div>
                            <span>收货人：{{ value.consignee }}</span>
                            <div style="float: right">
                                <span v-if="value.status == 0" class="warning">默认地址</span>
                                <el-button v-else-if="value.status == 1" type="text" @click="setAddress(key,value)"> 设为默认 </el-button>
                                <el-button type="text" @click="resetAddress(key,value)"> 编辑 </el-button>
                                <el-button type="text" @click="deleteAddress(key,value)"> 删除 </el-button>
                            </div>
                        </div>
                        <div>
                            <span>联系方式：{{ value.consignee_mobile }}</span>
                        </div>
                        <div>
                            <span>收货地址：{{ value.detailedAddress }}</span>
                        </div>
                    </el-card>
                </el-form-item>
                <el-dialog
                        :title="addressFormTitle"
                        :visible.sync="innerVisible"
                        append-to-body>
                    <el-card>
                        <el-form-item label="收货人：" :label-width="formLabelWidth">
                            <el-input v-model.trim="addressForm.consignee" auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="联系方式：" :label-width="formLabelWidth">
                            <el-input v-model.trim="addressForm.consignee_mobile" auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="收货地址：" :label-width="formLabelWidth">
                            <span style="display: block">选择市区</span>
                            <el-cascader
                                    size="large"
                                    :options="options"
                                    v-model="addressForm.code"
                                    @change="handleChange">
                            </el-cascader>
                            <span style="display: block">详细地址</span>
                            <el-input v-model.trim="addressForm.address_name" auto-complete="off"></el-input>
                        </el-form-item>
                    </el-card>
                    <div slot="footer" class="dialog-footer">
                        <el-button type="primary" @click="submitAddressForm">确 定</el-button>
                        <el-button @click="innerVisible = false">取 消</el-button>
                    </div>
                </el-dialog>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="addAddress">新 增</el-button>
                <el-button @click="dialogFormVisible = false">取 消</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import { regionData,CodeToText } from 'element-china-area-data'
    export default{
        data(){
            return {
                csrf_token: {
                    _token: document.querySelector('meta[name="csrf"]').content
                },
                fileList: [],
                ruleForm: {
                    customer_id     : 0,
                    product_id      : 0,
                    customer_name   : '',
                    product_name    : '',

                    item_ids        : [],
                    fact_pay        : 0,
                    should_pay      : 0,
                    pay_way_id      : 0,
                    user_defined    : '',
                    delivery_way_id : 0,

                    show_user_defined   : false
                },
                default_address:{
                    id              : '',
                    consignee       : '',
                    address_name    : '',
                    detailedAddress : '',
                    consignee_mobile: ''
                },
                skus                : [],
                pay_way             : [],
                delivery_way        : [],
                customs             : [],
                products            : [],
                old_product_id      : '',
                innerVisible        : false,
                dialogFormVisible   : false,
                defined_type        : 'info',

                options             : regionData,
                addressForm: {
                    id              : '',
                    consignee       : '',
                    code            : [],
                    address_name    : '',
                    consignee_mobile: ''
                },
                addresses           : [],
                addressKey          : null,
                formLabelWidth      : '90px',
                oldAddressIndex     : '',
                addressFormTitle    : '',

                customerStatus      : true,
                productStatus       : true
            }
        },
        methods : {
            //上传文件
            handleRemove(file, fileList) {
                console.log(file, fileList)
            },
            handlePreview(file) {
                console.log(file)
            },
            handleExceed(files, fileList) {
                this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件,超过三个文件请将之放在一个文件中压缩后上传`);
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`确定移除 ${ file.name }？`)
            },
            beforeImgUpload(file) {
                const isLt3M = file.size / 1024 / 1024 < 10;

                if (!isLt3M) {
                    this.$message.error('上传文件大小不能超过10MB!');
                }
                return isLt3M;
            },
            error:function (err,file,fileList) {
                this.$message.error(file.name+'上传失败！');
            },
            //地址
            handleChange (value) {
                console.log(value)
                console.log(CodeToText[value[0]])
                console.log(CodeToText[value[1]])
                console.log(CodeToText[value[2]])
            },
            customQuerySearch(queryString, cb) {
                var restaurants = this.customs
                var results = queryString ? restaurants.filter(this.createFilter(queryString)) : restaurants
                // 调用 callback 返回建议列表的数据
                console.log(results)
                if(results.length == 0){
                    this.customerStatus = false;
                    this.default_address = {
                        id              : '',
                        consignee       : '',
                        address_name    : '',
                        consignee_mobile: ''
                    }
                }else
                    this.customerStatus = true;
                cb(results)
            },
            productQuerySearch(queryString, cb) {
                var restaurants = this.products
                var results = queryString ? restaurants.filter(this.createFilter(queryString)) : restaurants
                // 调用 callback 返回建议列表的数据
                if(results.length == 0){
                    this.productStatus = false;
                    this.skus = []
                }else
                    this.productStatus = true;
                cb(results)
            },
            createFilter(queryString) {
                return (restaurant) => {
                    return (restaurant.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0)
                }
            },
            loadCustom() {
                var self = this
                axios.post('/admin/order/getCustomer').then(function (res) {
                    var data = res.data
                    if(data.code == 0){
                        self.customs = data.result
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
            loadProduct() {
                var self = this
                axios.post('/admin/order/getProduct').then(function (res) {
                    var data = res.data
                    if(data.code == 0){
                        self.products = data.result
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
            loadPayWay() {
                this.pay_way = [
                    { "id": 0, "name": "其他" },
                    { "id": 1, "name": "微信支付" },
                    { "id": 2, "name": "支付宝支付" },
                    { "id": 3, "name": "现金支付" },
                    { "id": 4, "name": "刷卡支付" }
                ]
            },
            loadDeliveryWay() {
                this.delivery_way = [
                    { "id": 0, "name": "自提" },
                    { "id": 1, "name": "送货上门" }
                ]
            },
            loadAddresses() {
                var self = this
                if(self.ruleForm.customer_id){
                    axios.post('/admin/order/getAddress',{ id : self.ruleForm.customer_id }).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            self.addresses = data.result
                            self.dialogFormVisible = true
                            self.addresses.forEach(function (value,index,arr) {
                                var codes = value.code.split('/')
                                arr[index].code = codes
                                arr[index].detailedAddress = ''
                                codes.forEach(function (value2) {
                                    arr[index].detailedAddress += CodeToText[value2]
                                })
                                arr[index].detailedAddress += value.address_name
                                if(value.status == 0){
                                    self.oldAddressIndex = index
                                    return
                                }
                            })
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err)
                    })
                }
            },
            customHandleSelect(item) {
                var self = this
                self.ruleForm.customer_id = item.id
                if(item.id){
                    axios.post('/admin/order/getDefaultAddress',{ id : self.ruleForm.customer_id }).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            var codes = data.result.code.split('/')
                            data.result.code = codes
                            self.default_address = data.result
                            self.default_address.detailedAddress = ''
                            codes.forEach(function (value) {
                                self.default_address.detailedAddress += CodeToText[value]
                            })
                            self.default_address.detailedAddress += self.default_address.address_name
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err);
                    })
                }
            },
            productHandleSelect(item) {
                //TODO::获取SKU
                var self = this
                self.ruleForm.product_id = item.id
                if(item.id){
                    axios.post('/admin/order/getSku',{ id : self.ruleForm.product_id }).then(function (res) {
                        var data = res.data
                        console.log(data.result)
                        if(data.code == 0){
                            self.skus = data.result
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err);
                    })
                }
                if(this.old_product_id !== this.ruleForm.product_id){
                    this.ruleForm.user_defined = ''
                    this.old_product_id = this.ruleForm.product_id
                }
            },
            tagClick(){
                this.ruleForm.show_user_defined = !this.ruleForm.show_user_defined
                if(this.ruleForm.show_user_defined){
                    this.defined_type = ''
                    this.ruleForm.item_ids = []
                }

                else
                    this.defined_type = 'info'
            },
            setAddress(key,item) {
                var self = this
                if(item.id && item.customer_id){
                    axios.post('/admin/order/setAddress',{ id : item.id,customer_id : item.customer_id }).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            self.addresses[self.oldAddressIndex].status = 1
                            self.addresses[key].status = 0
                            self.oldAddressIndex = key
                            self.default_address = self.addresses[key]
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err);
                    })
                }
            },
            resetAddress(key,item) {
                this.addressKey = key
                this.addressFormTitle = '编辑'
                this.addressForm = item
                this.innerVisible = true
            },
            addAddress() {
                this.addressKey = null
                this.addressFormTitle = '新增'
                this.addressForm = {
                    id              : '',
                    consignee       : '',
                    code            : [],
                    customer_id     : '',
                    address_name    : '',
                    consignee_mobile: ''
                };
                this.innerVisible = true
            },
            deleteAddress(key,item) {
                var self = this
                self.$confirm('此操作将永久删除该地址, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post('/admin/order/deleteAddress',{ id : item.id }).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            self.addresses.splice(key, 1)
                            if(item.status == 0){
                                self.default_address = {
                                    id              : '',
                                    consignee       : '',
                                    address_name    : '',
                                    consignee_mobile: ''
                                }
                            }
                            self.$message({
                                type: 'success',
                                message: '删除成功!'
                            })
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err);
                    })
                }).catch(() => {
                    /*self.$message({
                        type: 'info',
                        message: '已取消删除'
                    });*/
                })
            },
            addressTest(){
                // var reg_name    = /^[\u4E00-\u9FA5]{1,5}$/;
                var reg_mobile  = /^1[3|5|7|8]\d{9}$/
                var reg_phone    = /^0\d{2,3}-?\d{7,8}$/

                if(this.addressForm.consignee.length < 1 || this.addressForm.consignee.length > 10){
                    this.$message({
                        showClose: true,
                        message: '姓名长度错误',
                        type: 'warning'
                    })
                }else if(this.addressForm.address_name.length < 1 || this.addressForm.address_name.length > 25){
                    this.$message({
                        showClose: true,
                        message: '地址长度错误',
                        type: 'warning'
                    })
                }else if(!reg_mobile.test(this.addressForm.consignee_mobile) && !reg_phone.test(this.addressForm.consignee_mobile)){
                    this.$message({
                        showClose: true,
                        message: '电话号码错误',
                        type: 'warning'
                    })
                }else {
                    return true
                }
                return false
            },
            submitAddressForm(){
                var self = this
                if(self.addressTest()){
                    self.addressForm.customer_id = self.ruleForm.customer_id
                    axios.post('/admin/order/addAddress',self.addressForm).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            if(self.addressKey !== null){

                                self.addressForm.detailedAddress = ''
                                self.addressForm.code.forEach(function (value) {
                                    self.addressForm.detailedAddress += CodeToText[value]
                                })
                                self.addressForm.detailedAddress += self.addressForm.address_name

                                self.addresses[self.addressKey] = self.addressForm
                                if(self.addressForm.status == 0){
                                    self.default_address = self.addressForm
                                }
                            }else{

                                var codes = data.result.code.split('/')
                                data.result.detailedAddress = ''
                                data.result.code = codes
                                codes.forEach(function (value) {
                                    data.result.detailedAddress += CodeToText[value]
                                })
                                data.result.detailedAddress += data.result.address_name

                                self.addresses.push(data.result)
                            }
                            self.innerVisible = false
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err)
                    })
                }
            },
            test(){
                var reg_num  = /^[0-9]\d*$/
                var status = true
                if(this.ruleForm.customer_name.length == 0 || this.ruleForm.customer_id == 0){
                    this.$message({
                        showClose: true,
                        message: '客户不存在，请先添加客户',
                        type: 'warning'
                    })
                    status = false
                }else if(this.default_address.address_name.length == 0 || this.default_address.id  == 0){
                    this.$message({
                        showClose: true,
                        message: '请设置默认地址',
                        type: 'warning'
                    })
                    status = false
                }else if(this.ruleForm.product_name.length == 0 || this.ruleForm.product_id == 0){
                    this.$message({
                        showClose: true,
                        message: '产品不存在，请先添加产品',
                        type: 'warning'
                    })
                    status = false
                }else if(this.ruleForm.pay_way_id.length == 0){
                    this.$message({
                        showClose: true,
                        message: '请选择付款方式',
                        type: 'warning'
                    })
                    status = false
                }else if(this.ruleForm.delivery_way_id.length == 0){
                    this.$message({
                        showClose: true,
                        message: '请选择交货方式',
                        type: 'warning'
                    })
                    status = false
                }else if(!reg_num.test(this.ruleForm.should_pay) || !reg_num.test(this.ruleForm.fact_pay)){
                    console.log(this.ruleForm.should_pay)
                    this.$message({
                        showClose: true,
                        message: '付款只能填数字',
                        type: 'warning'
                    })
                    status = false
                }else if(this.ruleForm.should_pay < this.ruleForm.fact_pay){
                    this.$message({
                        showClose: true,
                        message: '实际付款大于应付款',
                        type: 'warning'
                    })
                    status = false
                }

                var self = this
                self.ruleForm.item_ids = []
                if(!self.ruleForm.show_user_defined){
                    self.skus.forEach(function (value) {
                        if(value.select)
                            self.ruleForm.item_ids.push(value.select)
                        else{
                            self.$message({
                                showClose: true,
                                message: '请选择商品属性:'+value.name,
                                type: 'warning'
                            })
                            status = false
                            return
                        }
                    })
                    self.ruleForm.item_ids = self.ruleForm.item_ids.join('/')
                }

                return status
            },
            submitForm() {
                var self = this
                if(self.test()){
                    console.log(self.ruleForm)
                    axios.post('/admin/order/addOrder',self.ruleForm).then(function (res) {
                        var data = res.data
                        if(data.code == 0){
                            self.$message({
                                type: 'success',
                                message: data.msg
                            })
                        }else{
                            self.$message({
                                type: 'error',
                                message: data.msg
                            })
                        }
                    }, function (err) {
                        console.log(err)
                    })
                }
            },
            resetForm(formName) {
                this.default_address = {
                    id              : '',
                    consignee       : '',
                    address_name    : '',
                    consignee_mobile: ''
                }
                this.sku = []
                this.$refs[formName].resetFields()
                this.ruleForm.show_user_defined = false
            }
        },
        mounted(){
            this.loadCustom()
            this.loadProduct()
            this.loadPayWay()
            this.loadDeliveryWay()
        }
    }
</script>
<style>
    .warning{
        background-color: rgba(230,162,60,.1);
        border: 1px solid rgba(230,162,60,.2);
        color: #e6a23c;
        padding: 0 10px;
        height: 32px;
        line-height: 30px;
        font-size: 12px;
        border-radius: 4px;
        box-sizing: border-box;
        display: inline-block;
    }
    .status{
        display: none;
    }
</style>
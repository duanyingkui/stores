<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>产品管理</el-breadcrumb-item>
                <el-breadcrumb-item>编辑产品</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <el-row>
            <el-col :span="14">
                <el-form :model="editForm" :rules="rules" ref="editForm" label-width="120px">
                    <el-form-item label="产品名称" prop="name">
                        <el-input v-model="editForm.name"></el-input>
                    </el-form-item>
                    <el-form-item label="产品列表图片" enctype="multipart/form-data"  prop="img_list">
                        <el-upload
                                action="admin/product/set_imglist"
                                ref="uploadlist"
                                name="file"
                                accept=".png,.jpg,.jpeg"
                                multiple
                                :data="csrf_token"
                                :limit="3"
                                list-type="picture"
                                :before-upload="beforeUpload"
                                :on-exceed="handleExceed"
                                :on-error="error"
                                :auto-upload="false"
                                :on-success="imglist">
                            <el-button slot="trigger" size="small" type="primary">选择图片</el-button>
                            <div slot="tip" class="el-upload__tip">请上传3个jpg/png/jpeg文件，单个文件大小不能超过2M</div>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="产品首页图片" prop="one_img">
                        <el-upload
                                class="img-uploader"
                                action="admin/product/set_imglist"
                                list-type="picture-card"
                                ref="uploadimg"
                                accept=".png,.jpg,.jpeg"
                                :data="csrf_token"
                                :limit="1"
                                :on-exceed="handleImgExceed"
                                :before-upload="beforeUpload"
                                :on-error="error"
                                :auto-upload="false"
                                :on-success="img">
                            <i class="el-icon-plus" slot="trigger"></i>
                            <div slot="tip" class="el-upload__tip">请上传1个jpg/png/jpeg文件，单个文件大小不能超过2M</div>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="是否启用SKU">
                        <el-switch
                                v-model="editForm.sku"
                                active-text="启用"
                                inactive="禁用">
                        </el-switch>
                    </el-form-item>
                    <el-form-item label="产品单位" prop="unit">
                        <!--<el-input v-model="editForm.unit"></el-input>-->
                        <el-select v-model="editForm.unit" filterable placeholder="请选择">
                            <el-option
                                    v-for="item in units"
                                    :key="item.id"
                                    :label="item.value"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="产品类型" prop="type">
                        <el-select v-model="editForm.type" filterable placeholder="请选择">
                            <el-option
                                    v-for="item in types"
                                    :key="item.id"
                                    :label="item.value"
                                    :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="产品详情">
                        <editor v-model="editForm.desc" name="html-editor" @input="getContent"></editor>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" size="small" @click="onSubmit(editForm)">保存</el-button>
                        <router-link to="/product/list"><el-button size="small" style="margin-left: 20px;">取消</el-button></router-link>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<style>
    .img-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .img-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .img {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>

<script>
    import editor from '../layout/editor.vue'
    export default {
        components: {
            editor,
        },
        data() {
            return {
                editForm: {
                    name: '',
                    unit: '',
                    type: '',
                    fileList: [],
                    oneimg: [],
                    sku: true,
                    desc: ''
                },
                units: [],
                types: [],
                rules: {
                    name: [
                        { required: true, message: '请输入产品名称', trigger: 'blur' },
                        { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
                    ],
                    unit: [
                        { required: true, message: '请选择产品单位', trigger: 'change' }
                    ],
                    type: [
                        { required: true, message: '请选择产品类型', trigger: 'change' }
                    ],
                },
                csrf_token: {
                    _token: document.querySelector('meta[name="csrf"]').content
                },
                id : Number.parseInt(this.$route.query.id),
            }
        },
        methods: {
            onSubmit(editForm) {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.uploadlists();
                        var self = this;
                        if(isNaN(this.id)){
                            console.log(self.editForm);
                            axios.post('/admin/product/add_product',self.editForm).then(function (res) {
                                var data = res.data;
                                if(data.code == 0){
                                    self.$message({
                                        type: 'success',
                                        message: data.msg
                                    });
                                }else{
                                    self.$message({
                                        type: 'error',
                                        message: data.msg
                                    });
                                }
                            }, function (err) {
                                console.log(err);
                            });
                        }
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            uploadlists:function(response) {
                this.$refs.uploadlist.submit();
                this.$refs.uploadimg.submit();
                // console.log(response);
            },
            imglist:function(res,file) {
                if(res.code == 0){
                    this.editForm.fileList.push(res.result);
                }else{
                    this.editForm.fileList.$remove(file);
                    this.$message.warning(file.name+'-文件上传失败,请重新上传');
                }
            },
            img:function(res,file) {
                if(res.code == 0){
                    this.editForm.oneimg.push(res.result);
                }else{
                    this.editForm.oneimg.$remove(file);
                    this.$message.warning(file.name+'-文件上传失败,请重新上传');
                }
            },
            error:function (err,file,fileList) {
                this.$message.warning('文件上传失败！');
            },
            handleExceed(files, fileList) {
                this.$message.warning(`当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件`);
            },
            beforeUpload(file) {
                const isPNG = file.type === 'image/png';
                const isJPEG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;
                if (!isPNG && !isJPEG) {
                    this.$message.error('上传图片只能是 JPG/PNG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传图片大小不能超过 2MB!');
                }
                return (isPNG || isJPEG) && isLt2M;
            },
            getContent(val){
                if(isNaN(this.id)){
                    this.editForm.desc = val;
                }
            },
            handleImgExceed(files,fileList){
                this.$message.warning('当前限制选择 1 个文件');
            },
            get_units(){
                var self = this;
                axios.get('/admin/product/get_units').then(function (res) {
                    console.log(res.data.result);
                    var data = res.data;
                    if(data.code == 0){
                       self.units = data.result;
                    }else{
                        self.$message({
                            type: 'error',
                            message: data.msg
                        });
                    }
                }, function (err) {
                    console.log(err);
                });
            },
            get_variety(){
                var self = this;
                axios.get('/admin/product/get_variety').then(function (res) {
                    console.log(res.data.result);
                    var data = res.data;
                    if(data.code == 0){
                       self.types = data.result;
                    }else{
                        self.$message({
                            type: 'error',
                            message: data.msg
                        });
                    }
                }, function (err) {
                    console.log(err);
                });
            },
        },
        mounted(){
            this.get_units();
            this.get_variety();
            if(isNaN(this.id)){
                this.editForm.desc = ' '
            }
        }
    }
</script>
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
                    <el-form-item label="产品列表图片" enctype="multipart/form-data">
                        <el-upload
                                action="admin/product/set_imglist"
                                ref="uploadlist"
                                name="file"
                                accept=".png,.jpg,.jpeg"
                                multiple
                                :data="csrf_token"
                                :limit="3"
                                :file-list="editForm.fileList"
                                list-type="picture"
                                :before-remove="beforeRemove"
                                :on-exceed="handleExceed"
                                :on-error="error"
                                :auto-upload="false">
                            <el-button slot="trigger" size="small" type="primary">选择图片</el-button>
                            <div slot="tip" class="el-upload__tip">至多上传3个jpg/png/jpeg文件，单个文件大小不能超过1M</div>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="产品首页图片">
                        <el-upload
                                class="img-uploader"
                                action="admin/product/set_imglist"
                                list-type="picture-card"
                                ref="uploadimg"
                                accept=".png,.jpg,.jpeg"
                                :data="csrf_token"
                                :limit="1"
                                :on-exceed="handleImgExceed"
                                :before-remove="handleImgRemove"
                                :before-upload="beforeImgUpload"
                                :on-error="error"
                                :auto-upload="false">
                            <i class="el-icon-plus" slot="trigger"></i>
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
                                v-for="item in editForm.units"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                    <el-form-item label="产品类型" prop="type">
                        <el-select v-model="editForm.type" filterable placeholder="请选择">
                            <el-option
                                    v-for="item in editForm.types"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
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
                    units: [{
                        value: '选项1',
                        label: '件'
                    }, {
                        value: '选项2',
                        label: '张'
                    }],
                    unit: '',
                    types: [{
                        value: '选项1',
                        label: '喷绘'
                    }, {
                        value: '选项2',
                        label: '写真'
                    }],
                    type: '',
                    fileList: [],
                    sku: true,
                    desc: ''
                },
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
                        this.uploadlist();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            uploadlist:function(response) {
                this.$refs.uploadlist.submit();
                this.$refs.uploadimg.submit();
            },
            error:function (err,file,fileList) {
                this.$message.warning('文件上传失败！');
            },
            beforeRemove(file, fileList) {
                return this.$confirm('确定移除 ${ file.name }？');
            },
            handleExceed(files, fileList) {
                this.$message.warning('当前限制选择 3 个文件，本次选择了 ${files.length} 个文件，共选择了 ${files.length + fileList.length} 个文件');
            },

            getContent(val){
                if(isNaN(this.id)){
                    this.editForm.desc = val;
                }
            },

            beforeImgUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG) {
                    this.$message.error('上传图片只能是 JPG 格式!');
                }
                if (!isLt2M) {
                    this.$message.error('上传图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            handleImgRemove(file, fileList) {
                console.log(file,fileList);
            },
            handleImgExceed(files,fileList){
                this.$message.warning('当前限制选择 1 个文件');
            }
        },
        mounted(){
            if(isNaN(this.id)){
                this.editForm.desc = ' '
            }
        }
    }
</script>

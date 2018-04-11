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
            <el-col :span="12">
                <el-form :model="editForm" :rules="rules" ref="editForm" label-width="100px">
                    <el-form-item label="产品名称" prop="name">
                        <el-input v-model="editForm.name"></el-input>
                    </el-form-item>
                    <el-form-item label="产品列表图片" prop="img" enctype="multipart/form-data">
                        <!-- <el-input v-model="editForm.img"></el-input> -->
                        <el-upload 
                            action="admin/product/set_imglist"
                            ref="upload"
                            name="file"
                            accept=".png,.jpg,.jpeg"
                            multiple
                            :data="csrf_token"
                            :limit="3"
                            :file-list="fileList"
                            list-type="picture"
                            :before-remove="beforeRemove"
                            :on-exceed="handleExceed"
                            :on-error="error"
                            :auto-upload="false">
                            <el-button slot="trigger" size="small" type="primary">选取文件</el-button>
                            <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUploads">上传到服务器</el-button>
                            <div slot="tip" class="el-upload__tip">至多上传3个jpg/png/jpeg文件，单个文件大小不能超过1M</div>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="是否启用SKU" prop="sku">
                        <el-switch
                            v-model="sku"
                            active-text="启用"
                            inactive="禁用">
                        </el-switch>
                    </el-form-item>
                    <el-form-item label="产品单位" prop="unit">
                            <el-input v-model="editForm.unit"></el-input>
                    </el-form-item>
                    <el-form-item label="产品详情">
                        <editor v-model="desc" name="html-editor" @input="getContent"></editor>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

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
                },
                rules: {
                    name: [
                        { required: true, message: '请输入产品名称', trigger: 'blur' },
                        { min: 3, max: 20, message: '长度在 3 到 20 个字符', trigger: 'blur' }
                    ],
                },
                fileList: [],
                csrf_token: {
                    _token: document.querySelector('meta[name="csrf"]').content
                },
                sku: true,
                desc: '',
                id : Number.parseInt(this.$route.query.id),
            }
        },
        methods: {
            submitUploads:function() {
                this.$refs.upload.submit();
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
                    this.desc = val;
                }
            }
        },
        mounted(){
            if(isNaN(this.id)){
                this.desc = ' ';
            }
        }
    }
</script>

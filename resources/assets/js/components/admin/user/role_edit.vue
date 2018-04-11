<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>角色管理</el-breadcrumb-item>
                <el-breadcrumb-item :to="{path:'/role/list'}">角色编辑</el-breadcrumb-item>
                <el-breadcrumb-item>编辑</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <router-link to="/role/list">
            <el-button size="small"><i class="el-icon-caret-left"></i> 返回</el-button>
        </router-link>
        <el-row  style="margin-top:10px;width:500px;">
            <el-col>
                <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                    <el-form-item label="角色名称" prop="name">
                        <el-input v-model="ruleForm.name" size="small" :disabled="inputDisabled"></el-input>
                    </el-form-item>
                    <el-form-item label="权限">
                        <el-tree ref="roleAuth"
                                 :data.sync="menu"
                                 :props="defaultProps"
                                 :node-key="defaultProps.nodeKey"
                                 :auto-expand-parent=true
                                 :default-expanded-keys="role_code"
                                 :default-checked-keys="role_code"
                                 show-checkbox
                                 :highlight-current=true
                                 style="height: 400px;overflow: auto;">
                        </el-tree>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary">提交</el-button>
                    </el-form-item>
                </el-form>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                ruleForm : {
                    id : 0,
                    name : ''  //角色名称
                },
                type : 1,    //角色类型
                inputDisabled : false,
                rules: {
                    name: [
                        {required: true, message: '请输入角色名称',trigger:'blur'}
                    ]
                },
                defaultProps : {
                    children : 'children',
                    label : 'name',
                    nodeKey : 'code'
                },
                menu : [],
                role_code : []
            }
        },
        watch :{
            type : function(newValue,oldValue){
                if(newValue == 0){
//                    this.inputDisabled = true;
//                    setTimeout(function(){
//                        $('input').attr('disabled',true);
//                    },300);
                }
            }
        },
        methods :{
            
        },
        mounted() {
            
        }
    }
</script>

<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>用户模块</el-breadcrumb-item>
                <el-breadcrumb-item>用户管理</el-breadcrumb-item>
                <el-breadcrumb-item>编辑</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <router-link to="/user/list">
            <el-button size="small"><i class="el-icon-caret-left"></i> 返回</el-button>
        </router-link>
        <el-row style="margin-top:15px;">
            <el-col style="width:400px;">
                <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="100px">
                    <el-form-item label="用户名" prop="name">
                        <el-input v-model="ruleForm.name"></el-input>
                    </el-form-item>
                    <el-form-item label="手机号" prop="phone">
                        <el-input v-model="ruleForm.phone"></el-input>
                    </el-form-item>
                    <el-form-item label="角色" prop="role_id">
                        <el-select v-model="ruleForm.role_id" placeholder="请选择用户角色">
                            <el-option
                                    v-for="role in roles"
                                    :key='role.id'
                                    :label="role.name"
                                    :value='role.id' >
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="默认密码" v-if="!id">
                        <el-input value="123456"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary">提交</el-button>
                        <el-button v-if="id" type="warning">重置密码</el-button>
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
                id : 0,
                desc: '',
                roles : [
                    {id:1,name:'员工'},
                    {id:2,name:'客户'}
                ],
                academy_visible : false,
                academys : [],
                ruleForm :{
                    name : '',
                    phone : '',
                    role_id : ''
                },
                rules : {
                    name : [
                        {required : true, message : '请输入用户名',trigger : 'blur'},
                        {min:5 , max : 20, message : '长度在5~20位',trigger : 'blur'}
                    ],
                    phone : [
                            {required : true, message : '请输入手机号',trigger : 'blur'}
                        ],
                    role_id : [
                        {required : true, message : '请选择用户角色'}
                    ]
                }
            }
        },
        methods : {

            role_change(role_id){
                var self = this;
                if(role_id != 1) {
                    this.get_academy_list();
                    self.rules = {
                        name : [
                            {required : true, message : '请输入用户名',trigger : 'blur'},
                            {min:5 , max : 20, message : '长度在5~20位',trigger : 'blur'}
                        ],
                        phone : [
                            {required : true, message : '请输入手机号',trigger : 'blur'}
                        ],
                        role_id : [
                            {required : true, message : '请选择用户角色'}
                        ]
                    };
                } else {
                    self.rules = {
                        name : [
                            {required : true, message : '请输入用户名',trigger : 'blur'},
                            {min:5 , max : 20, message : '长度在5~20位',trigger : 'blur'}
                        ],
                        phone : [
                            {required : true, message : '请输入手机号',trigger : 'blur'}
                        ],
                        role_id : [
                            {required : true, message : '请选择用户角色'}
                        ]
                    };
                }
            },

     
        },
        mounted() {
      
        }
    }
</script>

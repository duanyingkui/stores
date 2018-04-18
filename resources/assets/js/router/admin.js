import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/',
            component: resolve =>void(require(['../components/admin/layout/index.vue'], resolve))
        },
        {
            name: "自动回复",
            path: '/wx/reply',
            component: resolve =>void(require(['../components/admin/wx/reply.vue'], resolve))
        },
        {
            name: '基础配置',
            path: '/wx/config',
            component: resolve =>void(require(['../components/admin/wx/config.vue'], resolve))
        },
        {
            name: '模板配置',
            path: '/wx/template',
            component: resolve =>void(require(['../components/admin/wx/temp.vue'], resolve))
        },
        {
            name: '菜单配置',
            path: '/wx/menu',
            component: resolve =>void(require(['../components/admin/wx/menu.vue'], resolve))
        },
        {

            name: '编辑产品',
            path: '/product/edit',
            component: resolve => void(require(['../components/admin/product/ProductEdit.vue'], resolve))
        },
        {
            name: '新增订单',
            path: '/order/add',
            component: resolve =>void(require(['../components/admin/order/addOrder.vue'], resolve))
        },
        {
            name: '订单列表',
            path: '/order/list',
            component: resolve =>void(require(['../components/admin/order/orderList.vue'], resolve))
        },
        {
            name: '客户列表',
            path: '/customer/list',
            component: resolve =>void(require(['../components/admin/customer/customerList.vue'], resolve))
        },
        {
            name: '新增客户',
            path: '/customer/add',
            component: resolve =>void(require(['../components/admin/customer/addCustomer.vue'], resolve))
        },
        //用户模块
        {
            path: '/user/list',
            component: resolve => void (require(['../components/admin/user/user.vue'], resolve))
        },
        {
            path: '/user/edit',
            component: resolve => void (require(['../components/admin/user/user_edit.vue'], resolve))
        },
        {
            path: '/role/list',
            component: resolve => void (require(['../components/admin/user/role.vue'], resolve))
        },
        {
            path: '/role/edit',
            component: resolve => void (require(['../components/admin/user/role_edit.vue'], resolve))
        },
        {
            name: '新增供应商',
            path: '/supplier/add',
            component: resolve =>void(require(['../components/admin/supplier/addSupplier.vue'], resolve))
        },
    ]
})


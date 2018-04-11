import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

export default new VueRouter({
    saveScrollPosition: true,
    routes: [
        {
            name: "首页",
            path: '/',
            component: resolve =>void(require(['../components/wx/Wxtest.vue'], resolve))
        },
        {

            name: "首页",
            path: '/tt',
            component: resolve =>void(require(['../components/wx/TT.vue'], resolve))

        }
    ]
})


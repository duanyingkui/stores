/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./common.js');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.Vue = require('vue');

import Vue from 'vue'
import App from "./Admin.vue"
import router from './router/admin.js'
import ElementUI from "element-ui"
import 'element-ui/lib/theme-chalk/index.css'
import { filters } from './filter'

import 'bootstrap-sass/assets/javascripts/bootstrap/modal.js'
import 'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js'
import 'bootstrap-sass/assets/javascripts/bootstrap/tooltip.js'
import 'bootstrap-sass/assets/stylesheets/_bootstrap.scss'
import 'font-awesome/css/font-awesome.css'
import 'summernote'
import 'summernote/dist/lang/summernote-zh-CN.js'
import 'summernote/dist/summernote.css'

Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
})

require("es6-promise").polyfill()

Vue.use(ElementUI);

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});

Vue.prototype.time_conversion = function(date, pattern) {
    if (date == undefined) {
        date = new Date();
    } else {
        date = new Date(date*1000)
    }
    if (pattern == undefined) {
        pattern = "yyyy-MM-dd hh:mm:ss";
    }
    var o = {
        "M+": date.getMonth() + 1,
        "d+": date.getDate(),
        "h+": date.getHours(),
        "m+": date.getMinutes(),
        "s+": date.getSeconds(),
        "q+": Math.floor((date.getMonth() + 3) / 3),
        "S": date.getMilliseconds()
    }
    if (/(y+)/.test(pattern)) {
        pattern = pattern.replace(RegExp.$1, (date.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(pattern)) {
            pattern = pattern.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return pattern;
}

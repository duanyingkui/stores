<template>
    <div>
        <pageHeader></pageHeader>
        <div style="/*position:fixed;*/top:60px;bottom:0;left:0;right:0;">
            <div class="gm-main-wrap">
                <div class="page-menu">
                    <pageMenu></pageMenu>
                </div>

                <div class="page-content">
                    <div style="padding:10px 20px 35px;">
                        <router-view></router-view>
                    </div>
                    <div style="clear:both"></div>
                </div>

            </div>
        </div>
    </div>
</template>

<style>
    /* 减小 select 对象 loading 动画大小 */
    .el-select .el-loading-spinner .circular {
        width: 24px!important;
        height: 24px!important;
    }

    .el-select .el-loading-spinner {
        margin-top: -10px!important;
    }
</style>

<script>
    import pageHeader from './components/admin/layout/header.vue'
    import pageMenu from './components/admin/layout/menu.vue'

    export default {
        components: {
            pageHeader,
            pageMenu
        },
        data() {
            return {
//                activeIndex: '1',
//                activeIndex2: '1'
            };
        },
        methods: {
//            handleSelect(key, keyPath) {
//                console.log(key, keyPath);
//            }
        }
    }
</script>
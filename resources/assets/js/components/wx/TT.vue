<template>
    <div>
        <scroller lock-x @on-scroll="onScroll" ref="scroller" @on-pullup-loading="aaa" :on-pullup="true">
            <div>
                <p v-for="i in 5">placeholder {{i}}</p>
            </div>
        </scroller>
    </div>
</template>

<script>
    import { Group, Cell ,Scroller } from 'vux'
    export default{
        components: {
            Group,
            Cell,
            Scroller
        },
        data(){
            return {

            }
        },
        methods : {
            onScroll (pos) {
                this.$nextTick(() => {
                    this.$refs.scroller.reset()
                })
            },
            aaa(){

            }
        },
        mounted(){

        }
    }
</script>
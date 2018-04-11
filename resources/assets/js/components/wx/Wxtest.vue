<template>
    <div>
        <h1>Wx</h1>
        <el-button @click="visible = true">{{ time }}</el-button>
        <el-dialog v-model="visible" title="Hello world">
          <p>欢迎使用 Element</p>
        </el-dialog>
        <group>
          <cell title="title" value="I am Vux"></cell>
        </group>
        <img style="width: 100%;" src="/img/1-96.jpg">
    </div>
</template>

<script>
	import { Group, Cell } from 'vux'
    export default{
        components: {
            Group,
            Cell
        },
        data(){
            return {
                visible: false,
                time:new Date().format("yyyy年MM月dd日 hh点mm分ss秒")
            }
        },
        methods : {

        },
        mounted(){

        }
    }
</script>
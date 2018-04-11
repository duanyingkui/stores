<template>
    <div>
        <div class="gm-breadcrumb">
            <i class="ion-ios-home gm-home"></i>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
    </div>
</template>
<style scoped>
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
        text-align: center;
        padding:40px 0;
        font-size:30px;
    }
    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>
<script>
    export default{
        components : {

        },
        data(){
            return {
                span:4,
                offset:2,
                loading : false,
                kemu1:'----',
                kemu2:'----',
                kemu3:'----',
                kemu4:'----',
                over:'----',
                option : {
                    title: {
                        text: '招生走势'
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    /*legend: {
                        data:['招生','招生1']
                    },*/
                    /*grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },*/
                    /*toolbox: {
                        feature: {
                            saveAsImage: {}
                        }
                    },*/
                    xAxis: {
                        type: 'category',
                        boundaryGap: false,
                        data: [],
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'招生',
                            type:'line',
                            stack: '总量',
                            data:[],
                        }
                    ]
                },

            }
        },
        methods : {
            getSumData(){
                axios.get('/admin/getSumData').then(res=>{
                    this.kemu1 = res.data.kemu1;
                    this.kemu2 = res.data.kemu2;
                    this.kemu3 = res.data.kemu3;
                    this.kemu4 = res.data.kemu4;
                    this.over = res.data.over;
                })
            },
            geLineData(){
                var timer = new Date();
                var year = timer.getFullYear();
                var month = timer.getMonth();
                var day = timer.getDate();
                var today = Date.parse(year+'-'+(month+1)+'-'+day);
                var date = [];
                var show_date = [];
                show_date.push((month+1)+'月'+day+'日');
                date.push(today/1000);
                for(var i=30;i>0;i--){
                    today = today-3600*24*1000;
                    var temp_month = new Date(today).getMonth();
                    var temp_day = new Date(today).getDate();
                    show_date.push((temp_month+1)+'月'+temp_day+'日');
                    date.push(today/1000);
                }
                date.reverse();
                show_date.reverse();
                this.option.xAxis.data = show_date;
                axios.post('/admin/getLineData',{date:date,}).then(res=>{
                    this.option.series[0].data = res.data;
                    var myChart = echarts.init(document.getElementById('main'));
                    myChart.setOption(this.option);
                    window.onresize = myChart.resize;
                });
            },
        },
        mounted(){
//            this.getSumData();
//            this.geLineData();

        }
    }
</script>

<template>
  <div>
    <div v-title="'面板'"></div>
    <!--<el-alert-->
            <!--title="提醒"-->
            <!--type="warning"-->
            <!--style="margin-bottom: 20px;">-->
      <!--<div slot="defalut">-->
            <!--<p>这里放一些提醒信息</p>-->
      <!--</div>-->
    <!--</el-alert>-->
    <div>
    </div>
    <el-card class="row-20" shadow="hover">
      <div slot="header" class="clearfix">
        <span>出勤概况</span>
      </div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6"><div class="grid-content" style="background: #4fa8ed"><h1 style="display: inline">{{today.totalEmployeeCount}}</h1>总人数</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #ad97da"><h1 style="display: inline">{{today.todayAttendanceCount}}</h1>今日出勤</div></el-col>
          <el-col :span="6">
            <el-popover
                    placement="top-start"
                    width="200"
                    trigger="hover"
                    :content="today.todayLate.length?today.todayLate.join('\n'):''">
              <div slot="reference" class="grid-content" style="background: #3fc0c2"><h1 style="display: inline">{{today.todayLate?today.todayLate.length:''}}</h1>今日迟到</div>
            </el-popover>
          </el-col>
          <el-col :span="6">
            <el-popover
                    placement="top-start"
                    width="200"
                    trigger="hover"
                    :content="today.NotSigned.length?today.NotSigned.join('\n'):''">
              <div  slot="reference" class="grid-content" style="background: #f6d33a"><h1 style="display: inline">{{today.NotSigned?today.NotSigned.length:''}}</h1>今日缺卡</div>
            </el-popover>
          </el-col>
        </el-row>
      </div>
    </el-card>
    <el-card style="margin-top: 20px;" shadow="hover">
      <div class="l-month-select">
        <ul style="width: 70%; border-bottom: 1px solid #f1f1f1;padding-bottom: 10px;margin-bottom: 10px;">
          <li style="border:none;cursor: default">月份</li>
          <li v-for="m in months" @click="viewMonth" :class="{active: month == m}">{{m}}</li>
        </ul>
      </div>
      <v-chart :options="options2" style="width: 100%;height: 600px;"/>
    </el-card>
    <el-card style="margin-top: 20px;">
      <v-chart :options="options3" style="width: 100%;height: 800px;"/>
    </el-card>
  </div>

</template>
<script>
  import api from 'sysApi'
  import Vue from 'vue'
  import { Loading } from 'element-ui'
  import ECharts from 'vue-echarts' // refers to components/ECharts.vue in webpack

  // import ECharts modules manually to reduce bundle size
  import 'echarts/lib/chart/line'
  import 'echarts/lib/chart/bar'
  import 'echarts/lib/component/tooltip'
  import 'echarts/lib/component/title'
  import 'echarts/lib/component/polar'
  import 'echarts/lib/component/angleAxis'
  import 'echarts/lib/component/legend'

    /*
    // If you want to use ECharts extensions, just import the extension package, and it will work
    // Taking ECharts-GL as an example:
    // You only need to install the package with `npm install --save echarts-gl` and import it as follows
    import 'echarts-gl'
    */
    // register component to use
  Vue.component('v-chart', ECharts)

  export default {
      name: 'dashboard',
    data(){
        return {
            today:{
              totalEmployeeCount:0,
              todayAttendanceCount:0,
              todayLate:[],
              NotSigned:[]
            },
            months:['2020-05', '2020-06', '2020-07', '2020-08', '2020-09', '2020-10'],
            month: '2020-10',
            options2:{
                color:[
                    '#348498',
                    '#9A9FB6',
                    '#ff85cb',
                    '#FFD966',
                    '#fe4365',
                    '#7200da',
                    '#191919',
                    '#0057e7',
                    '#bc8420',
                    '#39BAE8',
                    '#79a701',
                    '#00c07f',
                    '#0072BB',
                    '#f58a2c',
                    '#A3320B',
                    '#CCFFBB',
                ],
                dataset: {
                    source: [['']]
                },
                grid:{
                    x:'2.2%',
                    y:'5%',
                    x2:'2.4%',
                    y2:'12%',
                    width: '97%',
                },
                title: {
                    text: '小组平均出勤时间'
                },
                tooltip: {},
                legend: {
                    data: []
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {},
                series: []
            },
            options3 : {
                color: ['#293c55'],
                title: {
                    text: '月份日平均工时',
                    subtext: ''
                },
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                // legend: {
                //     data: ['月平均工时']
                // },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                xAxis: {
                    type: 'value',
                    boundaryGap: [0, 0.01]
                },
                yAxis: {
                    type: 'category',
                    axisLabel: {
                        interval:0,
                        // rotate:20
                    },
                    data: []//['巴西', '印尼', '美国', '印度', '中国', '世界人口(万)']
                },

                series: [
                    {
                        name: '月平均工时',
                        type: 'bar',
                        data: []//[19325, 23438, 31000, 121594, 134141, 681807]
                    }
                ]
            }
    }
    },
    components: {
    },
    watch:{
        async month(val){
            await this.getDepartmentWeekAvgAttendance()
            await this.getMonthAvgAttendance()
        },
    },
    methods:{
        viewMonth(el){
            this.month = el.target.innerText
        },
        async getDepartmentWeekAvgAttendance(){
            let startLoad = Loading.service({ fullscreen: true, text: '获取中...', background: 'rgba(255,255,255,0.8)' })
            let res = await api.sniperDingGetDepartmentWeekAvgAttendance({month: this.month})
            startLoad.close()
            let items = res.data.values.filter((item) => {
                return item.slice(1).some((i)=>{return i})
            })

            this.options2.dataset.source.splice(0)
            this.options2.legend.data = []
            this.options2.series.splice(0)

            this.options2.dataset.source[0] = ['', ...res.data.departmentNames]
            this.options2.legend.data.push(...res.data.departmentNames)
            res.data.departmentNames.forEach(()=>{
                this.options2.series.push({type: 'bar'})
            })
            this.options2.dataset.source.push(...items)
        },
        async getMonthAvgAttendance(){
            let res = await api.sniperDingGetMonthAvgAttendance({month: this.month})
            let data = res.data
            console.log(JSON.stringify(data))
            let names = []
            let hours = []
            data.forEach((row) => {
                names.push(row.name)
                hours.push(row.hour)
            });

            this.options3.yAxis.data.splice(0,1000, ...names)
            this.options3.series[0].data.splice(0,1000, ...hours)

            this.options3.title.subtext = this.month
        },
        async getToday(){
            let res = await api.sniperDingGetToday()
            this.today = res.data
        }
    },
    async created(){
        await this.getDepartmentWeekAvgAttendance()
        await this.getToday()
        await this.getMonthAvgAttendance()
    }
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
  .l-month-select{
    border-bottom: 1px solid #f1f1f1;
    padding-bottom: 10px;
    margin-bottom: 10px;
    ul{
      display: flex;
      flex-flow: row nowrap;
      justify-content: flex-start;
      li{
        float: left;
        cursor: pointer;
        border: 1px solid #eee;
        border-radius: 3px;
        padding: 3px 8px;
        margin-right: 10px;
        &.active{
          color: #fff;
          border-color: #293c55;
          background-color: #293c55;
        }
      }
    }
  }
</style>


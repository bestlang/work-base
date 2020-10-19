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
            months:['2020-03', '2020-04', '2020-05', '2020-06', '2020-07', '2020-08', '2020-09', '2020-10'],
            month: '2020-10'
    }
    },
    components: {
    },
    watch:{
        async month(val){
        },
    },
    methods:{
        viewMonth(el){
            this.month = el.target.innerText
        },
        async getToday(){
            let startLoad = Loading.service({ fullscreen: true, text: '获取中...', background: 'rgba(255,255,255,0.8)' })
            let res = await api.sniperDingGetToday()
            this.today = res.data
            startLoad.close()
        }
    },
    async created(){
        await this.getToday()
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


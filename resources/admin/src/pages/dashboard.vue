<template>
  <div>
    <div v-title="'面板'"></div>
    <el-alert
            title="提醒"
            type="warning"
            style="margin-bottom: 20px;">
      <div slot="defalut">
            <p>这里放一些提醒信息</p>
      </div>
    </el-alert>
    <div>
    </div>
    <el-card class="row-20" shadow="hover">
      <div slot="header" class="clearfix">
        <span>系统技术栈</span>
      </div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6"><div class="grid-content" style="background: #4fa8ed">Laravel</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #ad97da">Javascript</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #3fc0c2">Mysql</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #f6d33a">CSS</div></el-col>
        </el-row>
      </div>
    </el-card>
    <!--<el-card>-->
      <v-chart :options="options" style="width: 1200px;height: 600px;display: none;"/>
    <!--</el-card>-->
  </div>

</template>
<script>
    import Vue from 'vue'
    import ECharts from 'vue-echarts' // refers to components/ECharts.vue in webpack

    // import ECharts modules manually to reduce bundle size
    import 'echarts/lib/chart/line'
    import 'echarts/lib/component/tooltip'
    import 'echarts/lib/component/polar'
    import 'echarts/lib/component/angleAxis'

    /*
    // If you want to use ECharts extensions, just import the extension package, and it will work
    // Taking ECharts-GL as an example:
    // You only need to install the package with `npm install --save echarts-gl` and import it as follows
    import 'echarts-gl'
    */
    // register component to use
    Vue.component('v-chart', ECharts)

  export default {
    data(){
        let onDuty = [{"value":["09/21",32460000]},{"value":["09/22",33000000]},{"value":["09/23",31200000]},{"value":["09/24",31800000]},{"value":["09/25",32100000]},{"value":["09/26",30240000]},{"value":["09/27",31800000]},{"value":["09/28",31800000]}]
        let offDuty = [{"value":["09/21",68400000]},{"value":["09/22",75600000]},{"value":["09/23",70800000]},{"value":["09/24",79200000]},{"value":["09/25",81000000]},{"value":["09/26",77400000]},{"value":["09/27",75600000]},{"value":["09/28",75600000]}]
        let anyDate = '2020/9/28 00:00:00'
        return {
            options:{
                grid:{
                    x:'6.6%',
                    y:'5%',
                    x2:'2.4%',
                    y2:'12%',
                    width: '100%'
                },
                yAxis:{
                    interval: 1800000,
                    min: 8 * 60 * 60 * 1000,
                    axisLabel:{
                        formatter:function(a){
                            let now = new Date(new Date(anyDate).getTime() + a)
                            return now.getHours() + now.toLocaleTimeString().substr(-6,3)
                        }
                    }
                },
                xAxis:{
                    type:'category',
                    boundaryGap: false
                },
                tooltip:{
                    trigger: 'axis',
                    axisPointer: {
                        type: 'none',
                        label: {
                            backgroundColor: '#6a7985'
                        }
                    },
                    formatter(params){
                        let result = []
                        params.forEach(function(item) {
                            let now = new Date(new Date(anyDate).getTime() + item.value[1])
                            let str = ''
                            let x =  now.getHours() + now.toLocaleTimeString().substr(-6,3)
                            str += '<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:' + item.color + '"></span>';
                            str += '<span style="font-size: 10px;">'+item.value[0] + item.seriesName + ":" + x + '</span>'
                            result.push(str)
                        });
                        return result.join('<br>')
                    }
                },
                series:[
                    {
                        name: '上班',
                        type: 'line',
                        showSymbol: true,
                        symbolSize:12,
                        stack: '上班',
                        data: onDuty,
                    },
                    {
                        name: '下班',
                        type: 'line',
                        showSymbol: true,
                        symbolSize:12,
                        stack: '下班',
                        data: offDuty,
                    },

                ]
            }
        }
    },
    components: {
    },
    watch:{
    },
    methods:{

    },
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
</style>


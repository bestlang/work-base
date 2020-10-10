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
      <!--<v-chart :options="options" style="width: 1200px;height: 600px;display: none;"/>-->
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
        return {
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


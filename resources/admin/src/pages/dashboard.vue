<template>
  <div>
    <div v-title="'面板'"></div>
    <el-alert
            title="提醒"
            type="warning"
            style="margin-bottom: 20px;">
      <div slot="default">
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
  </div>

</template>
<script>
  // import VueUeditorWrap from 'vue-ueditor-wrap';
  // import ueditorConfig from "../store/ueditor";
  // import TreeChart from "vue-tree-chart";
  import Vue from 'vue'
  // import jm from 'vue-jsmind'

  // Vue.use(jm)

  export default {
    data(){
      return {
      }
    },
    computed: {
      // ueditorConfig(){
      //   return ueditorConfig
      // }
    },
    components: {
    },
    watch:{
    },
    methods:{

    },
    created() {

    }
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
</style>


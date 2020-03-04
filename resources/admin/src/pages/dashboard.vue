<template>
  <div>
    <div v-title="'面板'"></div>
    <!--<el-alert-->
            <!--title="提个醒"-->
            <!--type="warning"-->
            <!--style="margin-bottom: 20px;">-->
      <!--<div slot="default">-->
            <!--<p>无情残忍</p>-->
            <!--<p>无情残忍</p>-->
            <!--<p>无情残忍</p>-->
      <!--</div>-->
    <!--</el-alert>-->
    <el-card class="row-20" shadow="hover">
      <div slot="header" class="clearfix">
        <span>活动效果</span>
      </div>
      <div>
        <el-row :gutter="20">
          <el-col :span="6"><div class="grid-content" style="background: #4fa8ed">1</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #ad97da">2</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #3fc0c2">3</div></el-col>
          <el-col :span="6"><div class="grid-content" style="background: #f6d33a">4</div></el-col>
        </el-row>
      </div>
    </el-card>
  </div>

</template>
<script>
  import VueUeditorWrap from 'vue-ueditor-wrap';
  import ueditorConfig from "../store/ueditor";
  export default {
    data(){
      return {
        index: 'some_random_string',
        content: '这是我设置的默认文本...'
      }
    },
    computed: {
      ueditorConfig(){
        return ueditorConfig
      }
    },
    components: {
      VueUeditorWrap
    },
    watch:{
      content(){}
    },
    methods:{
      setUeditor(instance, index){
      },
      getContent(){
        this.content = 'fuck';
      }
    },
    created() {}
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
</style>

<style lang="less" scoped>
  .l-content-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 50px - 20px);
    margin:-20px 0 -20px -20px;
    overflow-x: hidden;
    .l-tree-content{
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-flow: row nowrap;
      box-sizing: border-box;
      width: calc(100% - 240px);
    }
  }
</style>
<template>
  <div class="l-content-list">
    <channel-tree @nodeClick="handleNodeClick"></channel-tree>
    <div class="l-tree-content">
      fuck
    </div>
  </div>
</template>
<script>
  import channelTree from "./components/channelTree";
  export default {
    data() {
      return {
      }
    },
    components:{
      'channel-tree': channelTree
    },
    computed:{
      contents(){

      }
    },
    methods: {
      handleNodeClick(...params){
        let channelId = params[0][0].id;
        let channelName = params[0][0].name;
        let channelModelId = params[0][0].model_id;
        let channelTitle = params[0][0].title;
        // emit get contents action
      },
    },
    mounted() {
    }
  }
</script>


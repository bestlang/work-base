<template>
  <div>
    <div v-title="'面板'"></div>
    <el-alert
            title="提醒"
            type="warning"
            style="margin-bottom: 20px;">
      <div>
            <p>这里放一些提醒信息</p>
      </div>
    </el-alert>
    <el-button @click="throttledArrowClick">点我</el-button>
    <div>
    </div>
  </div>

</template>
<script>
    import throttle from 'throttle-debounce/throttle';

  export default {
    name: 'dashboard',
    data(){
        return {}
    },
    components: {
    },
    watch:{
    },
    methods:{
        doSomeThing(){
            console.log(`-------------1234-------------\n`)
        }
    },
    async created(){
        this.throttledArrowClick = throttle(5000, true,  _ => {
            this.doSomeThing()
        });
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


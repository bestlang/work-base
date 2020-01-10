<template>
  <div>
    <div class="l-top-menu">
      <div>
        <el-button type="primary">新增</el-button>
      </div>
      <el-form :inline="true">
        <el-form-item label="标题">
          <el-input placeholder="关键词"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary">查询</el-button>
        </el-form-item>
      </el-form>
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        loading: true,
        tableData: [],
        dialogFormVisible: false,
        form: {
          name: '',
          type: ''
        },
      }
    },
    methods:{
      add(){},
      submit(){},
      loadTypes(){}
    },
    created() {}
  }
</script>
<style lang="less" scoped>
  .l-top-menu {
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
  }
</style>

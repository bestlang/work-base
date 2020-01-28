<style lang="less">
  .iconfont{
    font-family: iconfont;
    font-style: normal;
  }
  .el-button{
    padding: 10px 20px;
  }
  .unselectable {
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  .l-flex-row{
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
  }
  .el-submenu__title, .el-menu-item{
    font-size: 15px;
  }
  .router-link-active{
    cursor: pointer;
  }
  .el-table .category-row {
    background: oldlace;
  }
  .el-table .content-row {
    background: #f0f9eb;
  }
  .el-tabs__item {
    font-size: 16px;
    font-weight: 500;
  }
  .l-block{
    width: 100%;
    overflow: hidden;
    background: #FFF;
    /*border: 1px solid #EBEEF5;*/
    /*border-radius: 4px;*/
    overflow: hidden;
    color: #303133;
    box-sizing: border-box;
    .l-block-header{
      padding: 18px 20px;
      border-bottom: 1px solid #EBEEF5;
      box-sizing: border-box;
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
      box-sizing: border-box;
    }
    .l-block-body{
      padding: 20px;
    }
  }
</style>
<template>
  <router-view></router-view>
</template>
<script>
export default {}
</script>

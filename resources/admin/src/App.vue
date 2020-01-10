<template>
  <router-view></router-view>
</template>
<script>
export default {}
</script>
<style>
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
    font-size: 16px;
  }
</style>

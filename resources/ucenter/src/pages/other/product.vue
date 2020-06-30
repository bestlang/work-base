<template>
    <div>
        <div><h3>其他商品</h3></div>
        <el-table v-loading="loading" :data="tableData" style="width: 100%">
        </el-table>
    </div>
</template>
<script>
  export default {
    data(){
      return {
        loading: false,
        tableData: [

        ],
      }
    }
  }
</script>
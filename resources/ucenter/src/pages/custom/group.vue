<template>
    <div>
        <div><h3>加工工艺</h3></div>
        <el-table v-loading="loading" :data="tableData" style="width: 100%">
            <el-table-column prop="id" label="编号"></el-table-column>
            <el-table-column prop="name" label="工艺名"></el-table-column>
            <el-table-column label="操作" width="200px">
                <template slot-scope="scope">
                    <el-button type="text">编辑</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>
<script>
  export default {
    data(){
      return {
        loading: false,
        tableData: [
          {id: "1", name: "库特智能-男套西-工艺"},
          {id: "2", name: "酷特只能-女单西-工艺"},
          {id: "3", name: "如意-男套西-工艺"},
          {id: "4", name: "如意-女单西-工艺"},
        ],
      }
    }
  }
</script>
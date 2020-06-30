<template>
    <div>
        <div><h3>所有商品</h3></div>
        <el-table v-loading="loading" :data="tableData" style="width: 100%">
            <el-table-column prop="id" label="编号"></el-table-column>
            <el-table-column prop="name" label="商品名称"></el-table-column>
            <el-table-column prop="group" label="绑定工艺"></el-table-column>
            <el-table-column prop="embr" label="绑定刺绣"></el-table-column>
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
          {id: "1", name: "库特智能-男套西", group: "库特智能-男套西-工艺", embr:"库特智能-男套西-刺绣"},
          {id: "2", name: "酷特只能-女单西", group: "酷特只能-女单西-工艺", embr:"酷特只能-女单西-刺绣"},
          {id: "3", name: "如意-男套西", group: "如意-男套西-工艺", embr:"如意-男套西-刺绣"},
          {id: "4", name: "如意-女单西", group: "如意-女单西-工艺", embr:"如意-女单西-刺绣"},
        ],
      }
    }
  }
</script>
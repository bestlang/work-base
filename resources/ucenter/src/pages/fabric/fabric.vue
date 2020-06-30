<template>
    <div>
        <div><h3>面料列表</h3></div>
        <el-table v-loading="loading" :data="tableData" style="width: 100%">
            <el-table-column prop="id" label="编号"></el-table-column>
            <el-table-column prop="name" label="面料编号"></el-table-column>
            <el-table-column prop="name" label="面料品牌"></el-table-column>
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
          {id: "1", number_f: "FB08-03", brand: "鲁泰LUTAI"},
          {id: "2", number_f: "510274", brand: "HUDDERSFIELD"},
        ],
      }
    }
  }
</script>
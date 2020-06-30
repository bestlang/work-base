<template>
    <div>
        <div><h3>商品品类</h3></div>
        <el-table v-loading="loading" :data="tableData" style="width: 100%">
            <el-table-column prop="id" label="编号"></el-table-column>
            <el-table-column prop="name" label="品类名称"></el-table-column>
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
            {id: "1", name: "男套西"},
            {id: "2", name: "女单西"},
          ],
        }
      }
    }
</script>
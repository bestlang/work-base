<template>
    <div>
        <div v-title="'人事变动'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                </div>
            </div>
            <div class="l-block-body">
                <el-table
                        :data="tableData"
                        border
                        style="width: 100%">
                    <el-table-column
                            prop="date"
                            label="日期"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="姓名"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="address"
                            label="变更前职位">
                    </el-table-column>
                    <el-table-column
                            prop="address"
                            label="变更后职位">
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                tableData: [{
                    date: '2016-05-02',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1518 弄'
                }, {
                    date: '2016-05-04',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1517 弄'
                }, {
                    date: '2016-05-01',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1519 弄'
                }, {
                    date: '2016-05-03',
                    name: '王小虎',
                    address: '上海市普陀区金沙江路 1516 弄'
                }]
            }
        }
    }
</script>
<style lang="less">

</style>
<template>
    <div class="l-block">
        <div class="l-block-header">
            <!--null-->
        </div>
        <div class="l-block-body">
            <el-table
                    :data="histories"
                    style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="用户"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="date"
                        label="时间"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="address"
                        label="操作">
                </el-table-column>
                <el-table-column
                        prop="ip"
                        label="IP地址">
                </el-table-column>
            </el-table>
        </div>
        <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
    </div>
</template>
<script>
    import api from 'sysApi'
    import pager from "@/components/pager"

    export default {
        components:{
            pager
        },
        data(){
            return {
                page:1,
                page_size: 8,
                total: 0,
                histories: [{
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
        },
        methods:{
            async getHistories(){
                let queryData = {page: this.page, page_size: this.page_size}
                let {data} = await api.getHistories(queryData)
                this.histories = data.histories;
                this.total = data.total;
            },
            async currentChange(page){
                this.page = page
                this.getHistories()
            }
        },
        async created(){
            await this.getHistories()
        }
    }
</script>
<template>
    <div class="l-block">
        <div class="l-block-header">
        </div>
        <!--<div class="l-block-body">-->
            <el-table
                    :data="histories"
                    style="width: 100%">
                <el-table-column
                        prop="id"
                        label="ID"
                        width="100">
                </el-table-column>
                <el-table-column
                        prop="user.name"
                        label="用户"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="created_at"
                        label="时间"
                        width="180">
                </el-table-column>
                <el-table-column
                        prop="action"
                        label="操作">
                </el-table-column>
                <el-table-column
                        prop="ip"
                        label="IP地址">
                </el-table-column>
            </el-table>
        <!--</div>-->
        <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
    </div>
</template>
<script>
    import api from 'sysApi'
    import pager from "@/components/pager"

    export default {
        name: 'history',
        components:{
            pager
        },
        data(){
            return {
                page:1,
                page_size: 15,
                total: 0,
                histories: []
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
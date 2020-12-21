<template>
    <div>
        <div class="l-block">
            <!--<div class="l-block-header"></div>-->
            <div class="l-block-body">
                <el-table
                        :data="notices"
                        style="width: 100%">
                    <el-table-column
                            label="人事公告">
                        <template slot-scope="scope">
                            <a @click="viewContentDetail(scope.row)" target="_blank" class="l-cursor">{{scope.row.title}}</a>
                        </template>
                    </el-table-column>
                    <el-table-column label="发布人" prop="user.name" width="100"></el-table-column>
                    <el-table-column label="发布时间" prop="send_at" width="180"></el-table-column>
                </el-table>
                <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
            </div>
        </div>
    </div>
</template>
<script>
    import api from "sysApi"
    import pager from "@/components/pager"

    export default {
        components: {
            pager
        },
        data(){
            return {
                total: 0,
                notices:[],
                page: 1,
                page_size: 10,
                channel_id: 37,//人事公告
                keyword: ''
            }
        },
        methods:{
            async getNotices(){
                let params = {
                    page: this.page,
                    page_size: this.page_size,
                    channel_id: this.channel_id
                }
                let {data} = await api.sniperEmployeePersonalNotices(params)

                this.notices = data.notices
                this.total = data.total || 0
            },
            async currentChange(page){
                this.page = page
                this.getNotices()
            },
            viewContentDetail({id}){
                this.$router.push('/panel/notice/detail?id='+id)
            }
        },
        created(){
            this.getNotices()
        }
    }
</script>
<style lang="less">
    .l-cursor{
        cursor: pointer;
    }
</style>
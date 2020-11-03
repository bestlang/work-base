<template>
    <div>
        <div class="l-block">
            <!--<div class="l-block-header"></div>-->
            <div class="l-block-body">
                <el-table
                        :data="contents"
                        style="width: 100%">
                    <el-table-column
                            label="标题">
                        <template slot-scope="scope">
                            <a @click="viewContentDetail(scope.row)" target="_blank" class="l-cursor">{{scope.row.title}}</a>
                        </template>
                    </el-table-column>
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
                contents:[],
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
                let {data} = await api.getExternalContents(params)

                this.contents = data.contents
                this.total = data.total
            },
            async currentChange(page){
                this.page = page
                this.getNotices()
            },
            viewContentDetail({id}){
                //this.$router.push('/panel/notice/detail?id='+id)
                window.open('/#/panel/notice/detail?id='+id, '_blank')
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
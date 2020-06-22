<template>
    <div>
        <div v-title="'评论管理'"></div>
            <div v-for="comment in comments">
                <div style="border: 1px solid #f1f1f1;padding: 0;margin-bottom: 5px;">
                    <div style="background: #f7f7f7;padding: 10px;border-bottom: 1px solid #eee;">
                        <a target="_blank" :href="comment.ref.link" style="color: #5C93BF;text-decoration: none;">
                            [{{comment.ref.channel.name}}]{{comment.ref.title}}
                        </a>
                        <span style="display: inline-block;margin-left: 50px;background: #fff;border-radius: 3px;padding: 3px 10px;border: 1px solid #eee;font-size: 14px;cursor: pointer;">查看本文全部评论</span>
                    </div>
                    <div style="padding: 20px 10px;">评论内容:{{comment.content}}</div>
                    <div style="padding: 0 10px 10px;">评论者: 评论时间: 评论IP:</div>
                </div>
            </div>
           <pager :total="total" :page-size="per_page" @current-change="currentChange"></pager>
    </div>
</template>
<script>
    import api from '../../api/index'
    import pager from "@/components/pager"

    export default {
        data(){
            return {
                comments: [],
                total: 0,
                per_page: 3,
                page: 1
            }
        },
        components:{
            pager
        },
        methods:{
            async loadComments(){
                let page = this.page;
                let per_page = this.per_page;
                const {data} = await api.getComments({page, per_page})
                this.comments = data.data;
                this.total = data.total;
                this.per_page = data.per_page;
            },
            async currentChange(page){
                this.page = page
                this.loadComments()
            }
        },
        async created() {
            await this.loadComments()
        }
    }
</script>
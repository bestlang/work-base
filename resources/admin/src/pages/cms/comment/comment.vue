<template>
    <div class="l-comments">
        <div v-title="'评论管理'"></div>
        <div v-for="comment in comments">
            <div class="l-comment-item">
                <div class="l-comment-head">
                    <a class="l-content-title" target="_blank" :href="comment.ref.link">
                        [{{comment.ref.channel.name}}]{{comment.ref.title}}
                    </a>
                    <span class="l-view-content" @click="viewContentComment(comment)">查看本文评论</span>
                </div>
                <div class="l-comment"><span class="lighter">评论内容:</span>{{comment.content}}</div>
                <div class="l-comment-foot">
                    <el-row>
                    <el-col :span="3"><span class="lighter">评论者:</span> {{comment.user?comment.user.name:'-'}}</el-col>
                    <el-col :span="6"><span class="lighter">评论时间:</span> {{comment.created_at}}</el-col>
                    <el-col :span="6"><span class="lighter">评论IP:{{comment.ip}}</span></el-col>
                    </el-row>
                </div>
            </div>
        </div>
       <pager :total="total" :page-size="per_page" @current-change="currentChange"></pager>
    </div>
</template>
<script>
    import api from 'sysApi'
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
                this.total = parseInt(data.total);
                this.per_page = parseInt(data.per_page);
            },
            async currentChange(page){
                this.page = page
                this.loadComments()
            },
            viewContentComment(comment){
//                console.log(`*******************`, JSON.stringify(comment))
                this.$router.push('/cms/comment/content?content_id='+comment.content_id);
            }
        },
        async created() {
            await this.loadComments()
        }
    }
</script>

<style lang="less" scoped>
    .lighter{
        color: #666;
    }
    .l-comments {
        .l-comment-item{
            border: 1px solid #f1f1f1;
            padding: 0;
            margin-bottom: 5px;
            .l-comment-head{
                background: #f7f7f7;
                padding: 10px;
                border-bottom: 1px solid #eee;
                .l-content-title{
                    color: #5C93BF;
                    text-decoration: none;
                }
                .l-view-content{
                    display: inline-block;
                    margin-left: 50px;
                    background: #fff;
                    border-radius: 3px;
                    padding: 3px 10px;
                    border: 1px solid #eee;
                    font-size: 14px;
                    cursor: pointer;
                }
            }
            .l-comment{
                padding: 20px 10px;
            }
            .l-comment-foot{
                font-size: 13px;
                padding: 0 10px 10px;
            }

        }

    }
</style>
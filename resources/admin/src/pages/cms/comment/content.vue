<template>
    <div class="l-comments l-block">
        <div v-title="'文章评论'"></div>
        <!--<div v-for="comment in comments">-->
            <div class="l-block-header">
                <div>
                    <span class="l-go-back" @click="goback"><span class="iconfont">&#xe601;</span>返回</span>
                    <el-divider direction="vertical"></el-divider>
                    <!--<i class="iconfont">&#xe64c;</i>「」-->
                    <span>文章下的评论</span>
                </div>
            </div>
            <div class="l-comment-item l-block-body l-mt-15">
                <div class="l-comment-head">
                    <a class="l-content-title" target="_blank" :href="content.link" v-if="content.channel">
                        [{{content.channel?content.channel.name:''}}]{{content.title}}
                    </a>
                </div>
                <template v-for="comment in content.comments">
                    <div class="l-comment-block">
                        <div class="l-comment"><span class="lighter">评论内容:</span>{{comment.content}}</div>
                        <div class="l-comment-foot">
                            <el-row>
                                <el-col :span="3"><span class="lighter">评论者:</span> {{comment.user?comment.user.name:''}}</el-col>
                                <el-col :span="6"><span class="lighter">评论时间:</span> {{comment.created_at}}</el-col>
                                <el-col :span="6"><span class="lighter">评论IP:{{comment.ip}}</span></el-col>
                            </el-row>
                        </div>
                    </div>
                </template>
            </div>
        <!--</div>-->
        <!--<pager :total="total" :page-size="per_page" @current-change="currentChange"></pager>-->
    </div>
</template>
<script>
    import api from 'sysApi'
    import pager from "@/components/pager"

    export default {
        name: 'cmsCommentContent',
        data(){
            return {
                content: {},
                total: 0,
                per_page: 4,
                page: 1,
                content_id: 0
            }
        },
        components:{
            pager
        },
        watch:{
            async content_id(val){
                if(val){
                    this.page = 1
                    await this.getComments()
                }
            }
        },
        methods:{
            goback(){
                this.$router.push('/cms/comment')
            },
            async getComments(){
                let page = this.page
                let per_page = this.per_page
                let content_id = this.content_id
                const {data} = await api.getContentComments({page, per_page, content_id})
                console.log(`特定文章`, JSON.stringify(data))
                this.content = data;
//                this.total = data.total;
//                this.per_page = data.per_page;
            },
            async currentChange(page){
                this.page = page
                this.getComments()
            }
        },
        async created() {
            //await this.getComments()
            this.content_id = parseInt(this.$route.query.content_id || 0);
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
            .l-comment-block{
                border-bottom: 1px solid #f1f1f1;
                .l-comment{
                    padding: 20px 10px;
                }
            }
            .l-comment-foot{
                font-size: 13px;
                padding: 0 10px 10px;
            }

        }

    }
</style>
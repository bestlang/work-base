<template>
    <div>
        <ol class="breadcrumb">
            <li><router-link to="/panel">首页</router-link></li>
            <li><router-link to="/panel/notice">公告</router-link></li>
            <li>正文</li>
        </ol>
        <div class="l-notice-content">
            <div class="l-text-center" style="margin-bottom: 30px;"><h3>{{content?content.title:''}}</h3></div>
            <div class="l-text-center l-small">发布人:{{author}} 发布日期: {{date}}</div>
            <div v-html="contentContent"></div>
        </div>
    </div>

</template>
<script>
    import api from "sysApi"

    export default {
        data(){
            return {
                content_id: 0,
                content: null
            }
        },
        computed:{
            date(){
                if(this.content){
                    return this.content.created_at
                }
            },
            author(){
                if(this.content && this.content.user){
                    return this.content.user.name
                }
            },
            contentContent(){
                if(this.content){
                    return this.content.contents.map((c) => { return c.value}).join('')
                }
            }
        },
        watch:{
            async content_id(newVal){
                if(newVal){
                    await this.getContent()
                }
            }
        },
        methods:{
            async getContent(){
                let params = {
                        content_id: this.content_id
                }
                let {data} = await api.getExternalContent(params)
                this.content = data
            }
        },
        mounted(){
            this.content_id = parseInt(this.$route.query.id) || 0;
        }
    }
</script>
<style lang="less">
    .l-text-center{text-align: center;}
    .l-notice-content{
        padding: 40px 20px;
        /*background: #fff;*/
        width: 70%;
        margin: 20px auto;
        font-weight: lighter;
        font-size: 14px!important;
    }
    .l-small{
        font-size: 13px;
    }
</style>
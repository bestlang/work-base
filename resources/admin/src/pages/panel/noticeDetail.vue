<template>
    <div>
        <ol class="breadcrumb">
            <li><router-link to="/panel">首页</router-link></li>
            <li><router-link to="/panel/notice">公告</router-link></li>
            <li>正文</li>
        </ol>
        <div class="l-notice-content">
            <div class="l-text-center" style="margin-bottom: 30px;"><h3>{{notice?notice.title:''}}</h3></div>
            <div class="l-text-center l-small" style="margin-bottom: 20px;font-style: italic;">发布人:{{author}} 发布日期: {{notice?notice.send_at:''}}</div>
            <div v-html="notice?notice.content:''"></div>
        </div>
    </div>

</template>
<script>
    import api from "sysApi"

    export default {
        data(){
            return {
                notice_id: 0,
                notice: null
            }
        },
        computed:{
            author(){
                if(this.notice && this.notice.user){
                    return this.notice.user.name
                }
            }
        },
        watch:{
            async notice_id(newVal){
                if(newVal){
                    await this.getNotice()
                }
            }
        },
        methods:{
            async getNotice(){
                let params = {
                        id: this.notice_id
                }
                let {data} = await api.sniperEmployeeNoticeDetail(params)
                this.notice = data
            }
        },
        mounted(){
            this.notice_id = parseInt(this.$route.query.id) || 0;
        }
    }
</script>
<style lang="less">
    .l-text-center{text-align: center;}
    .l-notice-content{
        padding: 0 20px 40px 20px;
        /*background: #fff;*/
        width: 70%;
        margin: 20px auto;
        font-weight: lighter;
        font-size: 14px!important;
    }
    .l-small{
        font-size: 13px;
    }
    .breadcrumb{margin-bottom: 0}
</style>
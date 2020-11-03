<template>
    <div>
        <div class="l-text-center" style="margin-bottom: 30px;"><h2>{{content?content.title:''}}</h2></div>
        <div class="l-text-center" v-html="content?content.contents[0].value:''"></div>
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
            this.content_id = parseInt(this.$route.query.id || 0);
        }
    }
</script>
<style lang="less">
    .l-text-center{text-align: center;}
</style>
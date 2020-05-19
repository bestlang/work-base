<template>
    <div>
        <div v-title="'评论管理'"></div>
            <div v-for="comment in comments">
                <div>文章:{{comment.ref.title}}</div>
                <div>评论内容:{{comment.content}}</div>
            </div>
    </div>
</template>
<script>
    import api from '../../api/index'

    export default {
        data(){
            return {
                comments: [],
                total: 0
            }
        },
        methods:{
            async loadComments(){
                let {data} = await api.getComments()
                this.comments = data;
//                this.total = data.total;
            }
        },
        async created() {
            await this.loadComments()
        }
    }
</script>
<template>
    <div class="ls-pager">
        <el-pagination
                background
                @current-change="currentChange"
                layout="prev, pager, next"
                :page-size="pageSize"
                :total="total">
        </el-pagination>
    </div>
</template>
<script>
    export default {
        props:{
            total:{
                type: Number,
                default: 1
            },
            pageSize: {
                type: Number,
                default: 15
            }
        },
//        data(){
//            return {
//                page: 1
//            }
//        },
        methods:{
            currentChange(page){
//                this.page = page;
                this.$emit(`current-change`, page);
            }
        }
    }
</script>
<style scoped>
    .ls-pager{
        text-align: left;
        margin: 20px 0;
    }
    .ls-pager >>> .el-pagination{
        padding-left: 0;
    }
    .ls-pager >>> .btn-prev{
        margin-left: 0;
    }
</style>
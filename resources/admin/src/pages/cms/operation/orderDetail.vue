<template>
    <div>
        <div v-title="'订单详情'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    <span class="l-go-back" @click="goBack"><span class="iconfont">&#xe601;</span>返回</span>
                    <el-divider direction="vertical"></el-divider>
                    <span>订单详情</span>
                </div>
            </div>
            <div class="l-block-body">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        methods:{
            goBack(){
                this.$router.push('/cms/operation/orders')
            }
        }
    }
</script>
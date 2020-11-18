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
                <div>{{order.name}}</div>
                <div>{{order.product_id}}</div>
                <div>{{order.order_no}}</div>
                <div>{{order.money}}</div>
                <div>{{order.user_id}}</div>
            </div>
        </div>
    </div>
</template>
<script>
    import api from 'sysApi'
    export default {
        data(){
            return {
                order_no: '',
                order: {}
            }
        },
        watch:{
            async order_no(order_no){
                let res = await api.getOrderDetail({order_no})
                if(!res.hasError){
                    this.order = res.data
                }
            }
        },
        methods:{
            goBack(){
                this.$router.push('/cms/operation/orders')
            }
        },
        mounted(){
            this.order_no = this.$route.query.order_no || 0;
        }
    }
</script>
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
                <div>商品名称:{{order.name}}</div>
                <!--<div>商品编号:{{order.product_id}}</div>-->
                <div>订单号:{{order.order_no}}</div>
                <div>订单金额:{{order.money}}元</div>
                <div>购买人:{{order.user.name}}</div>
                <div>订单状态:{{order.status_text}}</div>
                <div>支付方式:{{order.gateway_text}}</div>
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
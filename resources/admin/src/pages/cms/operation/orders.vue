<template>
	<div>
        <div>订单管理</div>
        {{tableData}}
	</div>
</template>
<script>
    import api from '../../../api/index'
	export default {
        data(){
            return {
                loading: false,
                tableData: []
            }
        },
        methods:{
            async getOrders(){
                let res = await api.getOrders()
                this.loading = false;
                this.tableData = res.data;
            }
        }
	}
</script>
<style scoped lang="less">

</style>
<template>
	<div>
        <div v-title="'订单管理'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    订单管理
                    <!--<el-button @click="handleAdd" type="primary" size="small">新增</el-button>-->
                </div>
                <div></div>
            </div>
            <div class="l-block-body">
                <el-table
                        v-loading="loading"
                        :data="orders"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="ID"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="user.name"
                            label="用户"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="商品名">
                    </el-table-column>
                    <el-table-column
                            prop="order_no"
                            label="订单号"
                            width="200">
                    </el-table-column>
                    <el-table-column
                            prop="money"
                            label="订单金额"
                            width="80">
                    </el-table-column>
                    <el-table-column
                            prop="status_text"
                            label="状态"
                            width="80">
                    </el-table-column>
                    <el-table-column
                            prop="gateway_text"
                            label="付款方式"
                            width="80">
                    </el-table-column>
                    <el-table-column
                            prop="created_at"
                            label="创建时间"
                            width="180">
                    </el-table-column>
                    <!--<el-table-column-->
                    <!--label="状态">-->
                    <!--<template slot-scope="scope">-->
                    <!--{{scope.row.enabled?'已启用':'未启用'}}-->
                    <!--</template>-->
                    <!--</el-table-column>-->
                    <!--<el-table-column-->
                            <!--label="操作">-->
                        <!--<template slot-scope="scope">-->
                            <!--&lt;!&ndash;<el-button type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>&ndash;&gt;-->
                            <!--&lt;!&ndash;<el-button type="text" size="small" @click="handleDelete(scope.row)">删除</el-button>&ndash;&gt;-->
                        <!--</template>-->
                    <!--</el-table-column>-->
                </el-table>
            </div>
        </div>

        <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
	</div>
</template>
<script>
    import api from '../../../api/index'
    import pager from "@/components/pager"
    export default {
        data(){
            return {
                loading: false,
                total: 0,
                page: 1,
                page_size: 10,
                orders: []
            }
        },
        components:{
            pager
        },
        methods:{
            async getOrders(){
                let page = this.page;
                let page_size = this.page_size;
                let res = await api.getOrders({page, page_size})
                let {total, orders} = res.data;
                this.loading = false;
                this.orders = orders;
                this.total = total;
            },
            async currentChange(page){
                this.page = page
                this.getOrders()
            }
        },
        created(){
            this.getOrders()
        }
	}
</script>
<style scoped lang="less">

</style>
<template>
    <div>
        <el-table :data="tableData"
                  style="width: 100%"
                  border
                  cell-class-name="cell-class"
                  header-cell-class-name="cell-class"
        >
            <el-table-column
                    label="图片"
                    width="100"
                    >
                <template slot-scope="scope">
                    <img :src="scope.row.goods_thumbnail_url" alt="" class="table-img" />
                </template>
            </el-table-column>

            <el-table-column
                    prop="goods_name"
                    label="名称">
            </el-table-column>

            <el-table-column
                    prop="goods_quantity"
                    label="购买数量"
                    width="80"
                    >
            </el-table-column>

            <el-table-column
                    label="实付金额"
                    width="80"
                    >
                <template slot-scope="scope">
                    {{scope.row.order_amount/100}}
                </template>
            </el-table-column>

            <el-table-column
                    label="订单状态"
                    width="80">
                <template slot-scope="scope">
                    {{scope.row.order_status_desc}}
                </template>
            </el-table-column>

            <el-table-column
                    prop="order_sn"
                    label="订单编号"
                    width="160"
                    >
            </el-table-column>

            <el-table-column
                    prop="custom_parameters"
                    label="自定参数"
                    width="80"
            >
            </el-table-column>
        </el-table>
        <div>
            <el-pagination
                layout="prev, pager, next"
                :total="200">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                params:{
                    page: 1,
                    page_size: 20
                },
                tableData: []
            }
        },
        methods:{
            loadOrders(){
                this.$http
                    .get("/pdd/order/list/range/get", {params: this.params})
                    .then(res => {
                        this.tableData = res.data;
                    });
            }
        },
        mounted(){
            this.loadOrders()
        }
    }
</script>

<style lang="less" scoped>
    .el-table .cell{
        text-align: left;
        text-indent: 10px;
    }
    img.table-img{
        width: 60px;
        height: 60px;
        border-radius: 5px;
    }
</style>
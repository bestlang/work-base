<template>
    <div>
        <div class="top-buttons">
            <el-button type="primary" @click="addActivity" size="small"><i class="iconfont">&#xe641;</i> 添加</el-button>
        </div>
        <!--<el-card class="box-card">-->
        <el-table
                border
                :data="tableData"
                cell-class-name="cell-class"
                header-cell-class-name="cell-class"
                style="width: 100%">
            <!--<el-table-column-->
                    <!--prop="id"-->
                    <!--label="ID"-->
                    <!--width="180">-->
            <!--</el-table-column>-->

            <el-table-column
                    label="图片"
                    width="100">
                <template slot-scope="scope">
                    <img :src="scope.row.thumbnail" alt="" class="table-img" />
                </template>
            </el-table-column>

            <el-table-column
                    label="类型"
                    width="120">
                <template slot-scope="scope">
                    <div v-for="(t,i) in types" v-if="t.id==scope.row.type">{{t.name}}</div>
                </template>
            </el-table-column>

            <el-table-column
                    prop="name"
                    label="名称">
            </el-table-column>

            <el-table-column
                    prop="status"
                    label="状态"
                    width="120">
            </el-table-column>

            <!--<el-table-column-->
                    <!--prop="start_time"-->
                    <!--label="起始时间"-->
                    <!--width="140">-->
            <!--</el-table-column>-->

            <!--<el-table-column-->
                    <!--prop="end_time"-->
                    <!--label="结束时间"-->
                    <!--width="140">-->
            <!--</el-table-column>-->

            <!--<el-table-column-->
                    <!--prop="deleted_at"-->
                    <!--label="删除时间"-->
                    <!--width="130">-->
            <!--</el-table-column>-->

            <el-table-column
                    fixed="right"
                    label="操作"
                    width="180">
                <template slot-scope="scope">
                    <el-button class="l-inline-btn" @click="handleEdit(scope.row)" type="text" size="small">查看</el-button>
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleEdit(scope.row)">编辑</el-button>
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleDelete(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="l-delimiter"></div>
        <el-pagination
                @current-change="handleCurrentChange"
                :current-page.sync="params.page"
                :page-size="params.page_size"
                layout="total, prev, pager, next"
                :total="total"></el-pagination>
        <!--</el-card>-->
    </div>

</template>

<script>
export default {
    data() {
        return {
            total: 0,
            params:{
                page: 1,
                page_size: 10
            },
            tableData: []
        }
    },
    computed:{
        types(){
            return this.$store.getters.activityTypes;
        }
    },
    methods: {
        handleEdit(row){
            this.$router.push('/activity/edit?activityId='+row.id)
        },
        async handleDelete(row){
            this.$confirm('是否删除?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning',
                center: true
            }).then(async () => {
                let res = await this.fetch("/admin/activity/delete", {activityId: row.id}, 'post')
                if(res.code == 200){
                    this.$message({
                        type: 'success',
                        message: '删除成功!'
                    });
                    await this.loadActivities();
                }

            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: '已取消删除'
                });
            });

        },
        addActivity(){
            this.$router.push('/activity/add')
        },
        handleCurrentChange(val) {
            // this.successMessage(`当前页: ${val}`);
            this.params.page = val;
            this.loadActivities();
        },
        async loadActivities(){
            let res = await this.fetch("/admin/activity/list", this.params)
            this.tableData = res.data.activities;
        },
        async loadPage(){
            let res = await this.fetch("/admin/activity/page", this.params)
            this.total =  res.data.total;
            console.log(`this.total`,this.total)
        }
    },
    mounted() {
        this.loadActivities()
        this.loadPage()
    }
}
</script>

<style scoped>
    img.table-img{
        width: 60px;
        height: 60px;
    }
</style>

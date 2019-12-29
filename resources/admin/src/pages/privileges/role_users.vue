<template>
    <div>
        <div class="top-buttons" style="display: flex;flex-flow: row nowrap;justify-content: space-between;">
            <el-button type="primary"><i class="iconfont">&#xe641;</i> 添加</el-button>
            <el-button @click="$router.push({path: '/privileges/roles'})"><span class="iconfont">&#xe665;</span></el-button>
        </div>
        <el-table
                border
                :data="tableData"
                cell-class-name="cell-class"
                header-cell-class-name="cell-class"
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="名字">
            </el-table-column>
            <el-table-column
                    prop="id"
                    label="id"
                    width="120">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作">
                <template slot-scope="scope">
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleDelete(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="l-delimiter"></div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                total: 0,
                tableData: []
            }
        },
        computed:{
            types(){
                return this.$store.getters.activityTypes;
            }
        },
        methods: {
            handleDelete(row){
              this.$confirm('确认删除该用户?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                this.$http
                  .post(`/admin/privileges/delete/role/model`, row.pivot)
                  .then(res => {
                    this.loadRoleUsers()
                  });
              }).catch(() => {});
            },
            loadRoleUsers(){
                this.$http
                    .get(`/admin/privileges/role/users/${this.$route.params.id}`)
                    .then(res => {
                        this.tableData = res.data;
                    });
            }
        },
        mounted() {
            this.loadRoleUsers()
        }
    }
</script>

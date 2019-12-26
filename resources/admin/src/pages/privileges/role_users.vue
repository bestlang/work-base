<template>
    <div>
        <div class="top-buttons" style="display: flex;flex-flow: row nowrap;justify-content: space-between;">
            <el-button type="primary" @click="addActivity"><i class="iconfont">&#xe641;</i> 添加</el-button>
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
                    label="操作"
                    width="180">
                <template slot-scope="scope">
                    <el-button class="l-inline-btn" @click="handleEdit(scope.row)" type="text" size="small">角色成员</el-button>
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleEdit(scope.row)">权限管理</el-button>
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
            handleEdit(row){
            },
            handleDelete(row){
            },
            loadRoles(){
                this.$http
                    .get("/admin/privileges/role/users/"+this.$route.params.id)
                    .then(res => {
                        this.tableData = res.data;
                    });
            }
        },
        mounted() {
            this.loadRoles()
        }
    }
</script>

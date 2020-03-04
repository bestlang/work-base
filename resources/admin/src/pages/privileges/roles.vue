<template>
    <div class="l-block">
        <div v-title="'角色管理'"></div>
        <div class="l-block-header">
            <el-button type="primary" size="small" @click="formVisible=true"><i class="iconfont">&#xe641;</i> 添加</el-button>
        </div>
        <div class="l-block-body">
          <el-table
                border
                :data="tableData"
                cell-class-name="cell-class"
                header-cell-class-name="cell-class"
                style="width: 100%">
            <el-table-column
                    prop="name"
                    label="角色名">
            </el-table-column>
            <el-table-column
                    prop="guard_name"
                    label="guard"
                    width="120">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作">
                <template slot-scope="scope">
                  <el-button class="l-inline-btn" @click="editRole(scope.row)" type="text" size="medium"><i class="iconfont">&#xe618;</i>编辑</el-button>
                  <el-button class="l-inline-btn" type="text" size="medium" @click="handleDelete(scope.row)"><i class="iconfont">&#xe620;</i>删除</el-button>
                  <el-button class="l-inline-btn" type="text" size="medium" @click="editRolePermissions(scope.row)"><i class="iconfont">&#xe64a;</i>权限</el-button>
                  <el-button class="l-inline-btn" @click="viewRoleUsers(scope.row)" type="text" size="medium"><i class="iconfont">&#xe6b0;</i>成员</el-button>
                </template>
            </el-table-column>
        </el-table>
        </div>
        <div class="l-delimiter"></div>
        <el-dialog :title="formTitle" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form" label-width="80px">
                <el-form-item label="角色名称">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false">取 消</el-button>
                <el-button type="primary" @click="handleSubmit">确 定</el-button>
            </div>
        </el-dialog>
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
                tableData: [],
                formVisible: false,
                formTitle: '添加角色',
                form: {
                    id: '',
                    name: ''
                }
            }
        },
        computed:{
            types(){
                return this.$store.getters.activityTypes;
            }
        },
        methods: {
            editRole(row){
              this.formVisible = true;
              this.form = Object.assign(this.form, {id: row.id, name: row.name})
            },
            handleSubmit(){
                this.$http.post('/admin/privileges/save/role', this.form)
                    .then(res => {
                        if(res.success){
                            this.formVisible = false;
                            this.loadRoles();
                        }
                    });
            },
            viewRoleUsers(row){
              this.$store.dispatch(this.$types.PRIVILEGE_CURRENT_ROLE, row)
              this.$router.push('/privileges/roles/users')
            },
            editRolePermissions(row){
              this.$store.dispatch(this.$types.PRIVILEGE_CURRENT_ROLE, row)
              this.$router.push('/privileges/roles/permissions')
            },
            handleDelete(row){
              this.$confirm('确认删除该角色?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                this.$http.post('/admin/privileges/delete/role/'+row.id)
                  .then(res => {
                    if(res.success){
                      this.$message({
                        type: 'success',
                        message: '删除成功!'
                      });
                      this.loadRoles();
                    }else{
                      this.$message({
                        type: 'info',
                        message: res.error
                      });
                    }
                  });
              }).catch(() => {});
            },
            addActivity(){
            },
            loadRoles(){
                this.$http
                    .get("/admin/privileges/roles", {params: this.params})
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

<style scoped>
    .el-dialog{width: 40%;}
</style>

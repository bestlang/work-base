<template>
    <div class="l-block">
        <div v-title="'角色管理'"></div>
        <div class="l-block-header">
            <el-button type="primary" size="small" @click="addRole"><i class="iconfont">&#xe641;</i> 添加</el-button>
        </div>
        <div class="l-block-body">
          <el-table
                border
                :data="tableData"
                cell-class-name="cell-class"
                header-cell-class-name="cell-class"
                style="width: 100%">
            <el-table-column
                  prop="id"
                  label="ID"
                  width="120">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="角色名"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="guard_name"
                    label="guard"
                    width="120">
            </el-table-column>
            <el-table-column
                    label="操作">
                <template slot-scope="scope">
                      <el-button @click="editRole(scope.row)" type="primary" size="mini"><i class="iconfont">&#xe618;</i>编辑</el-button>
                      <el-button type="danger" size="mini" @click="handleDelete(scope.row)"><i class="iconfont">&#xe620;</i>删除</el-button>
                      <el-button type="warning" size="mini" @click="editRolePermissions(scope.row)"><i class="iconfont">&#xe64a;</i>权限</el-button>
                      <el-button @click="viewRoleUsers(scope.row)" type="success" size="mini"><i class="iconfont">&#xe6b0;</i>成员</el-button>
                </template>
            </el-table-column>
        </el-table>
        </div>
        <div class="l-delimiter"></div>
        <el-dialog :title="formTitle" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form size="small" :model="form" label-width="80px">
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
    import api from 'sysApi'
    export default {
        name: 'privilegesRoles',
        data() {
            return {
                total: 0,
                params:{
                    page: 1,
                    page_size: 10
                },
                tableData: [],
                formVisible: false,
                formTitle: '',
                form: {
                    id: '',
                    name: ''
                }
            }
        },
        computed:{

        },
        methods: {
            addRole(){
                this.formTitle = '添加角色'
                this.formVisible = true
            },
            editRole(row){
              this.formVisible = true
              this.formTitle = '编辑角色'
              this.form = Object.assign(this.form, {id: row.id, name: row.name})
            },
            async handleSubmit(){
                let res = await api.saveRole(this.form)
                if(res.success){
                    this.formVisible = false
                    this.$message.success('操作成功！')
                    await this.loadRoles()
                }
            },
            viewRoleUsers(row){
              this.$store.dispatch(this.$types.privilegeCurrentRole, row)
              this.$router.push('/privileges/roles/users?role_id='+row.id)
            },
            editRolePermissions(row){
              this.$store.dispatch(this.$types.privilegeCurrentRole, row)
              this.$router.push('/privileges/roles/permissions?role_id='+row.id)
            },
            handleDelete(row){
              this.$confirm('确认删除该角色?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(async () => {
                let res = await api.deleteRole({id: row.id})
                if(res.success){
                  this.$message.success('删除成功!');
                  await this.loadRoles()
                }else{
                  this.$message.info(res.error);
                }
              }).catch(() => {})
            },
            async loadRoles(){
                let res = await api.getRoles(this.params)
                this.tableData = res.data
            }
        },
        async mounted() {
            await this.loadRoles()
        }
    }
</script>

<style scoped>
    .el-dialog{width: 40%;}
</style>

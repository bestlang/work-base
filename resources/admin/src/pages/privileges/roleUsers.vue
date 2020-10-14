<template>
    <div>
        <div class="top-buttons l-flex">
          <div>
                <router-link to="/privileges/roles" tag="span"><span class="iconfont">&#xe601;</span>返回</router-link>
                <el-divider direction="vertical"></el-divider>
                <span>「{{roleName}}」用户列表</span>
          </div>
          <div>
            <el-button type="primary" @click="addNewUser"><i class="iconfont">&#xe641;</i> 添加</el-button>
          </div>
        </div>
        <el-table
                border
                :data="tableData"
                cell-class-name="cell-class"
                header-cell-class-name="cell-class"
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="id"
                    width="120">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="昵称">
            </el-table-column>
            <el-table-column
              prop="mobile"
              label="手机号">
            </el-table-column>
            <el-table-column
                    fixed="right"
                    label="操作">
                <template slot-scope="scope">
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleRemove(scope.row)">移出</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="l-delimiter"></div>
        <el-dialog title="添加用户" :visible.sync="showForm" :close-on-click-modal="false">
            <el-form :model="form" label-width="80px">
                <el-form-item label="邮箱">
                    <el-input v-model="form.email" autocomplete="off" class="l-w-200"></el-input>
                </el-form-item>
                <el-form-item label="昵称">
                    <el-input v-model="form.name" autocomplete="off" class="l-w-200"></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="form.mobile" autocomplete="off" class="l-w-200"></el-input>
                </el-form-item>
                <el-form-item label="角色">
                    <el-checkbox-group v-model="form.roles">
                        <el-checkbox v-for="role in roles" :label="role.name"></el-checkbox>
                    </el-checkbox-group>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input v-model="form.password" autocomplete="off" class="l-w-200"></el-input>
                </el-form-item>
                <el-form-item label="确认密码">
                    <el-input v-model="form.confirm_password" autocomplete="off" class="l-w-200"></el-input>
                </el-form-item>

            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="showForm = false">取 消</el-button>
                <el-button type="primary" @click="doAddNewUser">确 定</el-button>
            </div>
        </el-dialog>
    </div>

</template>
<style lang="less" scoped>
</style>
<script>
    import api from 'sysApi'
    export default {
        data() {
            return {
                showForm: false,
                total: 0,
                tableData: [],
                roleName: '',
                role_id: null,
                roles:[],
                form: {
                    mobile: '',
                    password: '',
                    confirm_password: '',
                    name: '',
                    email: '',
                    roles: []
                }
            }
        },
        watch:{
            async role_id(val){
                await this.loadRoleUsers(val)
            },
            async showForm(val){
                if(val){
                    await this.getRoles()
                }
            },
            roles(val){
                if(val){
                    val.forEach((role) => {
                        if(role.id == this.role_id){
                            this.form.roles = [role.name]
                        }
                    })
                }
            }
        },
        computed:{
            types(){
                return this.$store.getters.activityTypes;
            },
            currentRole(){
              return this.$store.getters.currentRole;
            }
        },
        methods: {
            async getRoles(){
                let {data} = await api.getRoles()
                this.roles = data
            },
          addNewUser(){
            this.showForm = true;
            Object.assign(this.form, {
              mobile: '',
              password: '',
              confirm_password: '',
              name: ''
            });
          },
            async doAddNewUser(){
                let res = await api.createRoleUser(this.form)
                if(res.success){
                    this.showMessage('添加成功！', 'success')
                    await this.loadRoleUsers()
                    this.showForm = false;
                }else{
                    this.showMessage( res.error)
                }
            },
          handleRemove(row){
              this.$confirm('确认移出该用户?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(async () => {
                let res = await api.removeRoleModel(row.pivot)
                if(res.success){
                  await this.loadRoleUsers()
                }else{
                  this.$message({type:'error', message: res.error});
                }
              }).catch(() => {});
            },
            async loadRoleUsers(){
                let res = await api.getRoleUsers({id: this.role_id || 0})
                this.roleName = res.data.name;
                this.tableData = res.data.users;
            }
        },
        async mounted() {
            this.role_id = parseInt(this.$route.query.role_id || 0);
            await this.loadRoleUsers()
        }
    }
</script>

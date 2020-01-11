<template>
    <div>
        <div class="top-buttons" style="display: flex;flex-flow: row nowrap;justify-content: space-between;">
          <div style="display: flex;flex-flow: row nowrap;">
            <router-link to="/privileges/roles" tag="div"><span class="iconfont">&#xe601;</span>返回</router-link>
            <el-divider direction="vertical"></el-divider>
            <div>{{roleName}}用户</div>
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
                    prop="name"
                    label="昵称">
            </el-table-column>
            <el-table-column
              prop="mobile"
              label="手机号">
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
                    <el-button class="l-inline-btn" type="text" size="small" @click="handleRemove(scope.row)">移出</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="l-delimiter"></div>
        <el-dialog title="添加用户" :visible.sync="showForm">
          <el-form :model="form" label-width="80px">
            <el-form-item label="手机号">
              <el-input v-model="form.mobile" autocomplete="off" class="l-w-200"></el-input>
            </el-form-item>
            <el-form-item label="密码">
              <el-input v-model="form.password" autocomplete="off" class="l-w-200"></el-input>
            </el-form-item>
            <el-form-item label="确认密码">
              <el-input v-model="form.confirm_password" autocomplete="off" class="l-w-200"></el-input>
            </el-form-item>
            <el-form-item label="昵称">
              <el-input v-model="form.name" autocomplete="off" class="l-w-200"></el-input>
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
  .l-w-200{
    /*width: 280px;*/
  }
</style>
<script>
    export default {
        data() {
            return {
                showForm: false,
                total: 0,
                tableData: [],
                roleName: '',
                form: {
                  role_id: this.$route.params.id,
                  mobile: '',
                  password: '',
                  confirm_password: '',
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
          addNewUser(){
            this.showForm = true;
            Object.assign(this.form, {
              mobile: '',
              password: '',
              confirm_password: '',
              name: ''
            });
          },
          doAddNewUser(){
            this.$http
              .post(`/admin/user/create/role/user`, this.form)
              .then(res => {
                if(res.success){
                  this.loadRoleUsers()
                  this.showForm = false;
                }else{
                  this.$message({type:'error', message: res.error});
                }
              });
          },
          handleRemove(row){
              this.$confirm('确认移出该用户?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                this.$http
                  .post(`/admin/privileges/remove/role/model`, row.pivot)
                  .then(res => {
                    if(res.success){
                      this.loadRoleUsers()
                    }else{
                      this.$message({type:'error', message: res.error});
                    }
                  });
              }).catch(() => {});
            },
            loadRoleUsers(){
                this.$http
                    .get(`/admin/privileges/role/users/${this.$route.params.id}`)
                    .then(res => {
                      this.roleName = res.data.name;
                        this.tableData = res.data.users;
                    });
            }
        },
        mounted() {
            this.loadRoleUsers()
        }
    }
</script>

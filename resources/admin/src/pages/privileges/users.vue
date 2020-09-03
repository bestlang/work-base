<template>
    <div class="l-block">
        <div v-title="'用户管理'"></div>
        <div class="l-block-header">
            <el-button type="primary" size="small" @click="addUser"><i class="iconfont">&#xe641;</i> 添加</el-button>
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
                        label="用户昵称"
                        width="240">
                </el-table-column>
                <el-table-column
                        prop="email"
                        label="邮箱"
                        width="300">
                </el-table-column>
                <el-table-column
                        prop="mobile"
                        label="手机"
                        width="160">
                </el-table-column>
                <el-table-column
                        fixed="right"
                        label="操作">
                    <template slot-scope="scope">
                        <el-button class="l-inline-btn" @click="editUser(scope.row)" type="text" size="medium"><i class="iconfont">&#xe618;</i>编辑</el-button>
                        <!--<el-button class="l-inline-btn" @click="editPassword(scope.row)" type="text" size="medium"><i class="iconfont">&#xe75b;</i>修改密码</el-button>-->
                    </template>
                </el-table-column>
            </el-table>
            <pager :total="total" :page-size="params.page_size" @current-change="currentChange"></pager>
        </div>
        <div class="l-delimiter"></div>
        <el-dialog :title="formTitle" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form" label-width="80px">
                <el-form-item label="昵称">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="手机号">
                    <el-input v-model="form.mobile" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="邮箱">
                    <el-input v-model="form.email" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="">
                    <el-divider content-position="left" v-if="form.id" class="l-inline-notes">不修改密码请留空</el-divider>
                </el-form-item>
                <el-form-item label="密码" v-if="form.hasOwnProperty('password')">
                    <el-input v-model="form.password" autocomplete="new-password" placeholder="输入密码"></el-input>
                </el-form-item>
                <el-form-item label="重复密码" v-if="form.hasOwnProperty('confirm_password')">
                    <el-input v-model="form.confirm_password" autocomplete="new-password" placeholder="输入密码"></el-input>
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
    import api from '../../api/index'
    import pager from "@/components/pager"
    export default {
        data() {
            return {
                total: 0,
                params:{
                    page: 1,
                    page_size: 15
                },
                tableData: [],
                formVisible: false,
                formTitle: '',
                form: {
                    id: '',
                    name: '',
                    email: '',
                    mobile: '',
                    password: '',
                    confirm_password: ''
                }
            }
        },
        components:{
            pager
        },
        methods: {
            addUser(){
                this.form.id = ''
                this.form.name = ''
                this.form.email = ''
                this.form.mobile = ''
                //this.$set(this.form, 'password', '')
                //this.$set(this.form, 'confirm_password', '')
                this.formTitle = '添加用户'
                this.formVisible = true
            },
            editUser(row){
                //this.$delete(this.form, 'password')
                //this.$delete(this.form, 'confirm_password')
                this.formTitle = '编辑用户'
                this.formVisible = true
                let {id, name, email, mobile} = row
                this.form = Object.assign(this.form, {id, name, email, mobile, password: '', confirm_password: ''})
            },
            async handleSubmit(){
                let res = null
                if(this.form.id){
                    res = await api.updateUser(this.form)
                }else{
                    res = await api.createUser(this.form)
                }
                if(res.hasError){
                    this.showMessage(res.error, 'warning')
                }
                if(res.success){
                    this.formVisible = false;
                    await this.loadUsers();
                }
            },
            async loadUsers(){
                let {data} = await api.getUsers(this.params)
                this.tableData = data.users
                this.total = data.total
            },
            async currentChange(page){
                this.params.page = page
                this.loadUsers()
            }
        },
        async mounted() {
            await this.loadUsers()
        }
    }
</script>

<style scoped>
    .el-dialog{width: 40%;}
    .l-inline-notes /deep/ .el-divider__text{
        color: #606266;
        font-weight: normal
    }
</style>

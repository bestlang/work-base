<template>
    <div>
        <div v-title="'密码修改'"></div>
        <div class="l-block">
            <div class="l-block-header" style="display: flex;flex-flow: row nowrap;justify-content: space-between;">
                <div style="color: #999;">密码修改</div>
                <el-button type="primary" @click="save">提交</el-button>
            </div>
            <div class="l-block-body">
                <el-form size="small" ref="form" :model="form" label-width="100px" style="width: 50%;overflow-y: visible;">
                    <el-form-item label="当前密码">
                        <el-input v-model="form.password" type="password"></el-input>
                    </el-form-item>
                    <el-form-item label="新密码">
                        <el-input v-model="form.new_password" type="password"></el-input>
                    </el-form-item>
                    <el-form-item label="重复新密码">
                        <el-input v-model="form.new_password_confirmation" type="password"></el-input>
                    </el-form-item>
                </el-form>
            </div>
        </div>
    </div>
</template>
<script>
    import api from "sysApi"
    export default {
        name: 'passwordModify',
        data(){
            return {
                form: {
                    password: '',
                    new_password: '',
                    new_password_confirmation: ''
                }
            }
        },
        methods:{
            async save(){
                let res = await api.passwordModify(this.form)//{password: this.form.password}
                if(!res.hasError){
                    this.$alert('密码修改成功!', '提示', {
                        confirmButtonText: '确定',
                        callback: action => {
                            this.$store.dispatch('logout')
                        }
                    });
                }else{
                    this.$message.error(res.error);
                }

            }
        }
    }
</script>
<style lang="less">

</style>
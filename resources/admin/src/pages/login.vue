<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <h3>{{appName}}™管理端</h3>
        </div>
        <el-form :model="params" status-icon :rules="rules" ref="ruleForm" label-width="60px" class="demo-ruleForm">
            <el-form-item label="用户名" prop="mobile">
                <el-input type="text" v-model="params.mobile" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="密码" prop="password">
                <el-input type="password" v-model="params.password" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button :loading="loading" type="primary" @click="login">{{loginFont}}</el-button>
            </el-form-item>
        </el-form>
    </el-card>

</template>

<script type="text/javascript">

import api from "../api/index"

export default {
    data() {
        return {
            loading: false,
            loginFont: "Login",
            params: {
                mobile: '18625072568',
                password: '111111'
            },
            rules: {

            }
        }
    },
    computed:{
        appName(){
            return this.$store.getters.appName
        },
        accessToken(){
            return this.$store.getters.accessToken
        }
    },
    watch:{
        accessToken(newVal){
            console.log(`access token from store:`, newVal)
        }
    },
    methods: {
        requireMobile(){
            if(this.params.mobile == ""){
                $("#mobile").addClass("error").text("input mobile");
            }else{
                $("#mobile").removeClass("error").text(" ");
            }
        },
        requirePassword(){
            if(this.params.password == ""){
                $("#password").addClass("error").text("input password");
            }else{
                $("#password").removeClass("error").text(" ");
            }
        },
        changePassword(){
            $("#password").removeClass("error").text("");
        },
        async login() {
            if(!this.params.mobile || !this.params.password){
                this.requireMobile();
                this.requirePassword();
            }else{
                this.loading = true;
                this.loginFont = "logining...";
                let res = await api.login(this.params)
                if (res.code == 200) {
                    this.$store.commit(this.$types.ACCESS_TOKEN, res.data.access_token);
                    this.$store.commit(this.$types.USER, res.data.user);
                    let perm = await api.getUserPermissions()
                    if(perm && perm.data){
                        this.$store.commit(this.$types.PRIVILEGES, perm.data)
                    }
                    this.$router.push("/dashboard");
                }else if(res.code == 4011){
                   this.reset()
                }
                this.reset();
            }
        },
        reset() {
            this.loading = false;
            this.loginFont = "Login";
            this.params.password = "";
        }
    }
}
</script>

<style lang="less" scoped>

    @media screen and (min-width: 768px) {
        .box-card {
            width: 480px;
            margin: 100px auto;
            padding: 20px 50px 10px;
        }
    }
    @media screen and (max-width: 768px) {
        .box-card {
            width: 90vw;
            margin: 100px auto;
        }
    }

    .val label {
        position: absolute;
        top: 14px;
        right: 0px;
        z-index: 999;
        color: #ff0000;
        transition: 0.25s right linear;
        transform: translate(0, 0);
        font-size: 12px;
    }

    .val label.error {
        right: 48px;
        transition: 0.5s right;
    }
</style>

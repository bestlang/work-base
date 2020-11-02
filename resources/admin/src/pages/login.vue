<template>
    <el-card class="box-card">
        <div slot="header" class="clearfix">
            <!--™-->
            <h3>{{appName}}管理系统</h3>
        </div>
        <el-form :model="params" status-icon :rules="rules" ref="ruleForm" label-width="0" class="demo-ruleForm">
            <el-form-item prop="mobile">
                <!--label="用户名"-->
                <label>用户名</label>
                <el-input type="text" v-model="params.mobile" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item  prop="password">
                <!--label="密码"-->
                <label>密码</label>
                <el-input type="password" v-model="params.password" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button style="width: 100%;margin-top: 20px;" size="medium" :loading="loading" type="primary" @click="login">{{loginFont}}</el-button>
            </el-form-item>
        </el-form>
    </el-card>

</template>

<script type="text/javascript">

import api from "sysApi"
import {mapGetters} from 'vuex'
// import Cookies from 'js-cookie'
import { Loading } from 'element-ui'
import types from 'sysStore/types'

export default {
    data(){
        return {
            loading: false,
            loginFont: "登录",
            params:{
                mobile: '13222988085',
                password: '11111111'
            },
            rules:{

            }
        }
    },
    computed:{
        // appName(){
        //     return config.APP_NAME
        // },
        accessToken(){
            return this.$store.getters.accessToken
        },
        ...mapGetters(['appName'])
    },
    watch:{
        accessToken(newVal){
            console.log(`access token from store:`, newVal)
        }
    },
    methods: {
        requireMobile(){
            if(this.params.mobile == ''){
                $('#mobile').addClass('error').text('input mobile')
            }else{
                $('#mobile').removeClass('error').text('')
            }
        },
        requirePassword(){
            if(this.params.password == ''){
                $('#password').addClass('error').text('input password')
            }else{
                $('#password').removeClass('error').text('')
            }
        },
        changePassword(){
            $('#password').removeClass('error').text('')
        },
        async login(){
            if(!this.params.mobile || !this.params.password){
                this.requireMobile()
                this.requirePassword()
            }else{
                this.loading = true
                this.loginFont = 'login...'
                let res = await api.login(this.params)
                if (res.code == 200){
                    const {access_token, user} = res.data
                    if(access_token){
                        this.$store.commit('accessToken', access_token)
                    }
                    if(user){
                        this.$store.commit('user', user)
                    }
                    await this.$store.dispatch(types.privileges)
                    this.$router.push('/')
                }else if(res.code == 4011){
                   this.reset()
                }
                this.reset();
            }
        },
        reset() {
            this.loading = false;
            this.loginFont = 'Login'
            this.params.password = ''
        }
    }
}
</script>

<style lang="less" scoped>
    label{
        font-weight: 700;
    }
    @media screen and (min-width: 768px) {
        .box-card {
            width: 480px;
            margin: 100px auto;
            padding: 40px 50px 10px;
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

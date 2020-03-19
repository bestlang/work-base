<template>
    <div class="login-container">
        <div v-title="'登录'"></div>
        <div class="login-inner">
            <div style="width: 100vw; height: 100vh;">
            <el-row class="login-inner-box">
            <el-col class="login-form" :span="8" :offset="8">
                <div style="text-align: center;font-size: 36px;padding-bottom: 40px;">{{appName}}™</div>
                <div class="val user-after">
                    <input type="text" autocomplete="off" placeholder="mobile"
                           v-model="params.mobile"
                           @keyup.enter="login"
                           class="login-input user">
                    <label id="mobile"></label>
                </div>
                <div class="val password-after">
                    <input type="password" autocomplete="new-password" placeholder="password"
                           v-model="params.password"
                           @blur="requirePassword"
                           @keydown="requirePassword"
                           @keyup.enter="login"
                           class="login-input user">
                    <label id="password"></label>
                </div>
                <el-button :loading="loading"  class="login-input login-btn" type="primary" @click="login" id="login">{{loginFont}}</el-button>

            </el-col>

        </el-row>
        </div>
        </div>
    </div>
</template>

<script type="text/javascript">
export default {
    data() {
        return {
            loading: false,
            loginFont: "Login",
            params: {
                mobile: '18625072568',
                password: ''
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
                let res = await this.fetch("auth/login", this.params, 'post')
                if (res.code == 200) {
                    this.$store.commit(this.$types.ACCESS_TOKEN, res.data.access_token);
                    this.$store.commit(this.$types.USER, res.data.user);
                    let perm = await this.fetch("/admin/privileges/user/permissions")
                    if(perm && perm.data){
                        this.$store.commit(this.$types.PRIVILEGES, res.data)
                    }
                    this.$router.push("/dashboard");
                }else if(res.code == 4011){
                   this.restInfo()
                }
                this.restInfo();
            }
        },
        restInfo() {
            this.loading = false;
            this.loginFont = "Login";
            this.params.password = "";
        }
    }
}
</script>

<style lang="less" scoped>
    .login-input{
      text-indent: 15px;
    }
    .login-img{max-height: 50px;}
    .val {
        width: 320px;
        margin: 0 auto;
        position: relative;
        z-index: 99;
    }
    .user-after::after {
        position: absolute;
        top: 8px;
        left: 15px;
        color: #8ba6ba;
        font-family: "iconfont";
        font-size: 24px;
        content: "\e614";
    }
    .password-after::after {
        position: absolute;
        top: 10px;
        left: 16px;
        color: #8ba6ba;
        font-family: "iconfont";
        font-size: 24px;
        content: "\e75b";
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
    #login{
        text-indent: 0;
    }
</style>

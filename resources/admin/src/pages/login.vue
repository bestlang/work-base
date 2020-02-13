<template>
    <div class="login-container">
        <div class="login-inner-box">
            <div class="login-form">
                <div style="text-align: center;color: #fff;font-size: 36px;padding-bottom: 40px;">路章's博客</div>
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

            </div>

        </div>
        <!--<div class="fixed-bar">-->
            <!--<p>请使用谷歌浏览器(chrome)访问系统</p>-->
            <!--<p>ICP备案号</p>-->
            <!--<p>Copyright © 2007-2017 All Rights Reserved</p>-->
        <!--</div>-->
    </div>
</template>

<script type="text/javascript">
export default {
    data() {
        return {
            loading: false,
            loginFont: "登录",
            params: {
                mobile: '18625072568',
                password: "111111"
//                mobile: '',
//                password: ""
            }
        }
    },
    computed:{
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
        requireMobile() {
            if (this.params.mobile == "") {
                $("#mobile")
                    .addClass("error")
                    .text("请填写用户名");
            } else {
                $("#mobile")
                    .removeClass("error")
                    .text(" ");
            }
        },
        requirePassword() {
            if (this.params.password == "") {
                $("#password")
                    .addClass("error")
                    .text("请填写密码");
                $("#login").css("background", "#ebcd41");
            } else {
                $("#password")
                    .removeClass("error")
                    .text(" ");
                $("#login").css("background", "#fee300");
            }
        },
        changePassword() {
            $("#password")
                .removeClass("error")
                .text("");
        },
        login() {
            if (!this.params.mobile || !this.params.password) {
                this.requireMobile();
                this.requirePassword();
            } else {
                this.loading = true;
                this.loginFont = "正在登录...";
                this.$http
                    .post("auth/login", this.params)
                    .then(res => {
                        alert(JSON.stringify(res))
                        if (res.code == 200) {
                            this.$store.commit(this.$types.ACCESS_TOKEN, res.data.access_token);
                            this.$router.push("/dashboard");
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.restInfo();
                    });
            }
        },
        restInfo() {
            this.loading = false;
            this.loginFont = "登录";
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
</style>

<template>
    <div class="ls-top-wrap">
        <div class="ls-top-left">
            <div class="ls-icon-collapse" @click="toggleCollapse">
                <i class="iconfont">&#xe954;</i>
            </div>
        </div>
        <div class="ls-top-right"><div @click="logout" class="logout"><i class="iconfont">&#xe84b; </i>登出</div></div>
    </div>
</template>
<script>
export default {
  methods: {
    toggleCollapse() {
      this.$store.dispatch("toggleState")
    },
    logout(){
        this.$http
            .post("auth/logout")
            .then(res => {
                if (res.code == 200) {
                    this.$store.commit(this.$types.ACCESS_TOKEN, '');
                    this.$router.push("/login");
                }else if(res.code == 401){
                    this.$router.push("/login");
                }
            });
    }
  }
}
</script>
<style scoped lang="less">
    .ls-top-wrap{
        padding: 0;
    }
    .ls-top-left{
        float: left;
        text-align: right;
        box-sizing: border-box;
    }
    .ls-top-right{
        float: right;
        line-height: 49px;
        cursor: pointer;
        font-size:14px;
        color:darkblue;
        .logout{
            padding-right: 20px;
        }
    }
    .ls-top-logo{
        float: left;
        text-align: left;
        line-height: 49px;
        letter-spacing: .05em;
        padding-left: 30px;
        color:darkblue;
        letter-spacing: 1.5px;
        font-size: 20px;
    }
    .ls-icon-collapse{
        cursor: pointer;
        line-height: 49px;
        padding: 0 16px;
        font-size: 22px;
    }
</style>

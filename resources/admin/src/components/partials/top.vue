<template>
    <div class="ls-top-wrap">
        <div class="ls-top-left">
            <div class="ls-icon-collapse" @click="toggleCollapse">
                <i class="iconfont l-color">&#xe954;</i>
            </div>
        </div>
        <div class="ls-top-right">
          <el-dropdown>
            <div class="logout"><i class="iconfont">&#xe60d; </i>个人</div>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item><div @click="logout"><i class="iconfont">&#xe84b; </i>登出</div></el-dropdown-item>
              <el-dropdown-item><i class="iconfont">&#xe618; </i>修改密码</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
    </div>
</template>
<script>
  import custom from '../../../config/custom'
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
                    this.$router.push(custom.ADMIN_URI + "/login");
                }else if(res.code == 401){
                    this.$router.push(custom.ADMIN_URI + "/login");
                }
            });
    }
  }
}
</script>
<style scoped lang="less">
    .l-color{
      color:#4949BB;
    }
    .ls-top-wrap{
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        padding: 0;
    }
    .ls-left{
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-start;
        padding: 0;
    }
    .ls-top-left{
        /*float: left;*/
        text-align: right;
        box-sizing: border-box;
    }
    .ls-top-right{
        /*float: right;*/
        line-height: 50px;
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
        line-height: 50px;
        letter-spacing: .05em;
        padding-left: 30px;
        color:darkblue;
        letter-spacing: 1.5px;
        font-size: 20px;
    }
    .ls-icon-collapse{
        cursor: pointer;
        line-height: 50px;
        padding: 0 16px;
        font-size: 22px;
    }
</style>

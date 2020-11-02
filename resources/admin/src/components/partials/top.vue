<template>
    <div class="ls-top-wrap">
        <div class="ls-top-left">
            <div class="ls-icon-collapse" @click="toggleCollapse">
                <i class="iconfont l-color">&#xe954;</i>
            </div>
            <slot name="top-items" style="display: inline-block"></slot>
        </div>
        <slot name="center-nav"></slot>
        <div class="ls-top-right">
          <el-dropdown @command="commandHandler">
            <div class="logout"><i class="iconfont">&#xe60d; </i>{{user.name}}</div>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item command="panel"><div><i class="iconfont">&#xe614;</i>个人中心</div></el-dropdown-item>
              <el-dropdown-item command="modifyPassword"><i class="iconfont">&#xe618; </i>修改密码</el-dropdown-item>
                <el-dropdown-item command="logout"><div><i class="iconfont">&#xe84b; </i>登出</div></el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
    </div>
</template>
<script>
import api from '../../api/index'
import { getPrefix } from '../../api/util'
import {mapGetters} from 'vuex'
// import Cookies from 'js-cookie'

export default {
  computed: {
      ...mapGetters(['user','privileges', 'accessToken', 'csrf'])
  },
  watch:{
      accessToken:{
          handler(newVal){
                if(!newVal){
                    if(getPrefix() == 'api'){
                        this.$router.push('/login')
                    }else{
                        location.href='/login'
                    }
                }
          }
      }
  },
  methods: {
    async commandHandler(command){
        if(command == 'logout'){
            await this.logout()
        }else if(command == 'panel'){
            this.$router.push('/panel')
        }else{
            this.$message('还没做')
        }
    },
    toggleCollapse() {
      this.$store.dispatch("toggleState")
    },
    async logout(){
        await this.$store.dispatch('logout')
    }
  },
  async created(){
        if(getPrefix() == 'ajax'){
            //做api方式登录成功后做的操作
            if(!this.user || !this.user.length){
                await this.$store.dispatch(this.$types.user)
            }
            if(!this.privileges || !this.privileges.length){
                await this.$store.dispatch(this.$types.privileges)
            }
            if(!this.csrf){
                await this.$store.dispatch(this.$types.csrf)
            }
            // if(!Cookies.get(this.$types.logined)){
            //     Cookies.set(this.$types.logined, true, new Date(new Date().getTime() + 10 * 60 * 1000))
            // }
        }
  }
}
</script>
<style scoped lang="less">
    .l-top-item{
        &.active{
            background: #f1f1f1;
         }
    }
    .l-color{
      /*color:#409EFF;*/
      color:#2d2d2d;
    }
    .ls-top-wrap{
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
        padding: 0;
        background: #f8f8f8;
        height: 100%;
    }
    .ls-top-left{
        text-align: right;
        box-sizing: border-box;
        position: relative;
        .ls-icon-collapse{
            cursor: pointer;
            line-height: 50px;
            padding: 0 16px;
            font-size: 22px;
            display: inline-block;
        }
        >div{
            display: inline-block;
        }
        .l-top-item{
            height: 50px;
            line-height: 50px;
            padding: 0 20px;
            color: #303133;
            &:hover{
                 background: #f1f1f1;
                 color: #2d2d2d;
                 cursor: pointer;
             }
        }

    }
    .ls-top-right{
        text-align: right;
        padding-right: 10px;
        min-width: 100px;
        line-height: 50px;
        cursor: pointer;
        font-size:14px;
        color:#409EFF;
        .logout{
            padding-right: 20px;
        }
    }

</style>

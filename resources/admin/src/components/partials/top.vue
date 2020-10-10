<template>
    <div class="ls-top-wrap">
        <div class="ls-top-left">
            <div class="ls-icon-collapse" @click="toggleCollapse">
                <i class="iconfont l-color">&#xe954;</i>
            </div>
            <slot name="top-items"></slot>
        </div>
        <div class="ls-top-right">
          <el-dropdown>
            <div class="logout"><i class="iconfont">&#xe60d; </i>{{user.name}}</div>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item><div @click="logout"><i class="iconfont">&#xe84b; </i>登出</div></el-dropdown-item>
              <el-dropdown-item><i class="iconfont">&#xe618; </i>修改密码</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
    </div>
</template>
<script>
import api from '../../api/index'
import { getPrefix } from '../../api/util'
import {mapGetters} from 'vuex'
import Cookies from 'js-cookie'

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
            if(!Cookies.get(this.$types.logined)){
                Cookies.set(this.$types.logined, true, new Date(new Date().getTime() + 10 * 60 * 1000))
            }
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
    .ls-left{
        display: flex;
        flex-flow: row nowrap;
        justify-content: flex-start;
        padding: 0;
    }
    .ls-top-left{
        text-align: right;
        box-sizing: border-box;
        position: relative;
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
        line-height: 50px;
        cursor: pointer;
        font-size:14px;
        color:#409EFF;
        .logout{
            padding-right: 20px;
        }
    }
    .ls-icon-collapse{
        cursor: pointer;
        line-height: 50px;
        padding: 0 16px;
        font-size: 22px;
        display: inline-block;
        position: absolute;
        left: 0;
        top: 0;
    }
</style>

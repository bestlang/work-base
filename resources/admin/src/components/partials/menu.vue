<style scoped lang="less">
    .ls-top-logo{
        /*color: #00a2d4;*/
        color: gray;
    }
    .ls-top-logo, .ls-top-logo-narrow{
        line-height: 50px;
        font-size: 18px;
        padding: 0 20px;
        background: #f8f8f8;
        /*background: #f5f5f5;*/
        /*border-bottom: 1px solid #e6e6e6;*/
    }
</style>

<template>
    <div class="l-menu-wrap">
        <!--™-->
        <div class="ls-top-logo" v-show="!isCollapse">
            <b>{{appName}}</b><b>管理面板</b>
        </div>
        <div class="ls-top-logo-narrow" v-show="isCollapse">{{appShortName}}</div>
        <el-menu
                :unique-opened="true"
                ref="sidemenu"
                class="el-menu-vertical"
                @open="handleOpen"
                @close="handleClose"
                router
                :default-active="defaultActive"
                :collapse="isCollapse">
              <template  v-for="(item , index) in router.options.routes">
                <template  v-if="item.children  && item.children.filter(x=>x.meta.show).length">
                  <template v-for="child in item.children">
                    <cell :item="child" :type="child.children && item.children.filter(x=>x.meta.show).length ? 'el-submenu':'el-menu-item'"></cell>
                  </template>
                </template>
              </template>
        </el-menu>
    </div>
</template>

<style scoped>
    .l-menu-wrap{
    }
    .el-menu{
        border-right: 1px solid transparent;
        height:calc(100vh - 50px);
        overflow: hidden;
    }

    .el-menu-vertical{
        min-height: calc(100vh - 50px);
    }
    .el-menu-vertical:not(.el-menu--collapse) {
        width: 200px;
        overflow-y: auto;
    }

</style>

<script>
    import $router from "@/router"
    import cell from "./cell"
    import api from "../../api/index"
    import {mapGetters} from 'vuex'
    import config from "../../../config/prod.env"
    export default {
      components:{
        cell
      },
      data() {
          return {
            defaultActive:'',
            router: $router,
//            privileges: []
          };
      },
      computed:{
          appName(){
              return config.APP_NAME
          },
          appShortName(){
              return config.APP_SHORT_NAME
          },
          ...mapGetters([
              'isCollapse',
              'privileges'
          ])
      },
      watch:{
          privileges(newVal){
              if(newVal.length){
                  let routes = this.router.options.routes;
                  this.resetVisible(routes, newVal)
              }
          }
      },
      methods: {
          handleOpen(key, keyPath) {
//              console.log(key, keyPath);
          },
          handleClose(key, keyPath) {
//              console.log(key, keyPath);
          },
          resetVisible(routes, privileges){
            routes.map((route, index) => {
              if(route.hasOwnProperty('children')){
                route.children.map((child, idx) => {
                  if(privileges.indexOf(route.children[idx].meta.can) === -1){
                    route.children[idx].meta.show = false
                  }
                });
                this.resetVisible(route.children, privileges)
              }
            });
          }
      },
    async created() {
        this.defaultActive = this.$route.path;
        if(!this.privileges.length){
            let perm = await api.getUserPermissions()
            let user = await api.getUserInfo()
            let csrf = await api.csrf()
            if(perm && perm.data){
                this.$store.commit(this.$types.PRIVILEGES, perm.data)
            }
            if(user && user.data){
                this.$store.commit(this.$types.USER, user.data);
            }
            if(csrf && csrf.data){
                this.$store.commit(this.$types.CSRF, csrf.data);
            }
        }
      }
    }
</script>

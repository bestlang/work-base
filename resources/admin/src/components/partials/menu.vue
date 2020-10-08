<template>
    <div class="l-menu-wrap">
        <!--™-->
        <div class="ls-top-logo" v-show="!isCollapse">
            <p>{{appName}}管理面板</p>
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
                <template  v-if="showOrNot(item)">
                  <template v-for="child in item.children">
                    <cell :item="child" :type="calType(child)" v-if="showOrNot(child)"></cell>
                  </template>
                </template>
              </template>
        </el-menu>
    </div>
</template>

<style scoped lang="less">
    .ls-top-logo{
        font-size: 18px;
        letter-spacing: 1px;
    }

    .ls-top-logo, .ls-top-logo-narrow{
        color: #f1f1f1;
        height: 50px;
        line-height: 50px;
        padding: 0 20px;
        background: #293c55;
    }

    .ls-top-logo-narrow{
        font-size: 14px;
    }

    .l-menu-wrap{
        /deep/ .el-menu{
            background: #293c55;
            .el-menu-item{
                color: #f1f1f1;
                &.is-active, &:hover{
                    color: #2d2d2d;
                    background: #8c939d;
                    i{
                        color: inherit;
                    }
                }
            }
            .el-submenu{
                .el-submenu__title{
                    color: #f1f1f1;
                    &:hover{
                        color: #2d2d2d;
                        i{
                            color: inherit;
                        }
                    }
                }
            }
        }
        .el-menu-vertical{
            min-height: calc(100vh - 50px);
            background: #293c55;
            border-right: none;
            &:not(.el-menu--collapse) {
                width: 200px;
                overflow-y: auto;
                border-right: none;
            }
        }
    }

    .el-menu{
        overflow: hidden;
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
          }
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
          privileges:{
              handler(newVal){
                  if(!newVal){
                      newVal = []
                  }
                  let routes = this.router.options.routes
                  this.resetVisible(routes, newVal)
              },
              immediate: true,
              deep: true
          }
      },
      methods: {
          calType(item){
              return item.children && item.children.filter(x=>x.meta.show).length ? 'el-submenu':'el-menu-item'
          },
          showOrNot(item){
              return ( !item.children || item.children && item.children.filter(x=>x.meta.show).length )
          },

          handleOpen(key, keyPath) {

          },
          handleClose(key, keyPath) {

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
        this.defaultActive = this.$route.path
        if(!this.privileges.length){
            let perm = await api.getUserPermissions()
            let user = await api.getUserInfo()
            let csrf = await api.csrf()
            if(perm && perm.data){
                this.$store.commit(this.$types.privileges, perm.data)
                let routes = this.router.options.routes
                this.resetVisible(routes, perm.data)
            }
            if(user && user.data){
                this.$store.commit('user', user.data)
            }
            if(csrf && csrf.data){
                this.$store.commit(this.$types.CSRF, csrf.data)
            }
        }
      }
    }
</script>

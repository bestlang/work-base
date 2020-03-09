<style scoped lang="less">
    .ls-top-logo, .ls-top-logo-narrow{
        line-height: 50px;
        font-size: 18px;
        padding: 0 20px;
    }
</style>

<template>
    <div>
        <div class="ls-top-logo" v-show="!isCollapse">{{appName}}</div>
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
                    <cell :item="child"  :type="child.children && item.children.filter(x=>x.meta.show).length ? 'el-submenu':'el-menu-item'"></cell>
                  </template>
                </template>
              </template>
        </el-menu>
    </div>
</template>

<style scoped>
    .el-menu{
        border-right: 1px solid transparent;
    }
    .el-menu-vertical{
        /*height: calc(100vh - 50px);*/
    }
    .el-menu-vertical:not(.el-menu--collapse) {
        width: 200px;
    }

</style>

<script>
    import $router from "@/router"
    import cell from "./cell"
    export default {
      components:{
        cell
      },
      data() {
          return {
            defaultActive:'',
            router: $router,
            privileges: []
          };
      },
      computed:{
          appName(){
              return this.$store.getters.appName
          },
          appShortName(){
              return this.$store.getters.appShortName
          },
          isCollapse(){
              return this.$store.state.system.isCollapse;
          }
      },
      methods: {
          handleOpen(key, keyPath) {
              console.log(key, keyPath);
          },
          handleClose(key, keyPath) {
              console.log(key, keyPath);
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
          },
          async loadUserPermissions(){
            let res = await this.$http.get("/admin/privileges/user/permissions")
            this.privileges = res.data
            this.$store.commit(this.$types.PRIVILEGES, res.data)
            let routes = this.router.options.routes;
            this.resetVisible(routes, this.privileges)
          }
      },
    created() {
        this.defaultActive = this.$route.path;
        this.loadUserPermissions();
      }
    }
</script>

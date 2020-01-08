<style scoped lang="less">
    .ls-top-logo, .ls-top-logo-narrow{
        line-height: 50px;
        font-size: 18px;
        padding: 0 20px;
    }
</style>

<template>
    <div>
        <div class="ls-top-logo" v-show="!isCollapse">路章の博客</div>
        <div class="ls-top-logo-narrow" v-show="isCollapse">路</div>
        <el-menu
                ref="sidemenu"
                class="el-menu-vertical"
                @open="handleOpen"
                @close="handleClose"
                router
                :default-active="defaultActive"
                :collapse="isCollapse">
              <template  v-for="(item , index) in router.options.routes">
<!--                <template v-if="item.children && item.children.filter(x=>x.meta.show).length > 1"> &lt;!&ndash; 子栏目数量大于1 &ndash;&gt;-->
                <template  v-if="item.children">
                  <template v-for="child in item.children">
                    <cell :item="child"  :type="child.children && child.children.length ? 'el-submenu':'el-menu-item'"></cell>
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
          //@todo
          // make privileges global awared: vuex
          loadUserPermissions(){
            this.$http
              .get("/admin/privileges/user/permissions")
              .then(res => {
                this.privileges = res.data
                localStorage.setItem(`privileges`, JSON.stringify(res.data));
                //查询出用户的权限列表,根据权限列表过滤路由生成菜单
                let routes = this.router.options.routes;
                routes.map((route, index) => {
                  if(route.hasOwnProperty('children')){
                    route.children.map((child, idx) => {
                      if(this.privileges.indexOf(route.children[idx].meta.can) === -1){
                        route.children[idx].meta.show = false
                      }
                    });
                  }
                });
              });
          }
      },
    // mounted() {
    //   console.log(`-------------->route path:`,this.$route.path);
    // },
    created() {
        this.defaultActive = this.$route.path;
      // console.log(`-------------->route path:`,this.$route.path);
      // this.$nextTick(function(){
      //   this.$refs.sidemenu.open('/dashboard/home');
      // })
        this.loadUserPermissions();
      }
    }
</script>

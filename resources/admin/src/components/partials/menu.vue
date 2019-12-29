<style scoped lang="less">
    .ls-top-logo, .ls-top-logo-narrow{
        line-height: 49px;
        font-size: 18px;
        padding: 0 20px;
    }
</style>

<template>
    <div>
        <div class="ls-top-logo" v-show="!isCollapse">路章's博客</div>
        <div class="ls-top-logo-narrow" v-show="isCollapse">路's</div>
        <el-menu
                class="el-menu-vertical"
                @open="handleOpen"
                @close="handleClose"
                router
                :collapse="isCollapse">
              <template  v-for="(item , index) in router.options.routes">
                <template v-if="item.children && item.children.filter(x=>x.meta.show).length > 0">
                  <el-submenu :index="item.path">
                    <template slot="title">
                      <i class="iconfont" v-html="item.meta.font"></i>
                      <span slot="title">
                        {{item.meta.name}}
                      </span>
                    </template>
                    <template v-for="(itemChild , index) in item.children">
                      <el-menu-item v-if="itemChild.meta.show" :index="itemChild.path" :key="index">
                          <i class="iconfont" v-html="itemChild.meta.font"></i>
                          <span slot="title">{{itemChild.meta.name}}</span>
                      </el-menu-item>
                    </template>
                  </el-submenu>
                </template>
                <template v-else>
                  <el-menu-item v-if="item.children && item.children[0].meta.show" :index="item.children[0].path">
                    <template slot="title">
                      <i class="iconfont" v-html="item.meta.font"></i>
                      <span slot="title">{{item.children[0].meta.name}}</span>
                    </template>
                  </el-menu-item>
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
        /*height: calc(100vh - 49px);*/
    }
    .el-menu-vertical:not(.el-menu--collapse) {
        width: 200px;
    }

</style>

<script>
    import $router from "@/router"
    export default {
        data() {
            return {
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
            loadUserPermissions(){
              this.$http
                .get("/admin/privileges/user/permissions")
                .then(res => {
                  this.privileges = res.data
                  localStorage.setItem(`privileges`, JSON.stringify(res.data));
                  //查询出用户的权限列表,根据权限列表过滤路由生成菜单
                  let routes = this.router.options.routes;
                  routes.map((route, index) => {
                    if(!route.hasOwnProperty('children')){
                      if(this.privileges.indexOf(route.meta.can) === -1){
                        route.meta.show = false
                      }
                    }else{
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
        created() {
          this.loadUserPermissions();
        }
    }
</script>

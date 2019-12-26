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
              <template  v-for="(item , index) in $router.options.routes" v-if="true">
                <el-submenu :index="item.path" v-if="item.children && item.children.length > 1">
                  <template slot="title">
                    <i class="iconfont" v-html="item.meta.font"></i>
                    <span slot="title">{{item.meta.name}}</span>
                  </template>
                  <el-menu-item v-for="(itemChild , index) in item.children" :index="itemChild.path" :key="index" v-if="itemChild.meta.show">
                    <i class="iconfont" v-html="itemChild.meta.font"></i>
                    <span slot="title">{{itemChild.meta.name}}</span>
                  </el-menu-item>
                </el-submenu>
                <template v-else>
                  <el-menu-item v-if="item.children" :index="item.children[0].path">
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
            return {};
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
            }
        },
        created() {
          console.log(`ddddd:`,$router)
        }
    }
</script>

<template>
    <div>
          <el-submenu role="submenu" v-if="showSubMenu" :index="item.path">
              <div slot="title">
                <i class="if" v-html="font"></i>
                <span slot="title">{{name}}</span>
              </div>
              <div v-for="child in item.children">
                <sub-menu :item="child"></sub-menu>
              </div>
          </el-submenu>
          <el-menu-item v-else-if="showMenuItem" :index="item.path">
              <i class="if" v-html="font"></i>
              <span slot="title">{{name}}</span>
          </el-menu-item>
    </div>
</template>

<script>
  // 每一个menu-item都可能是一个submenu
  export default {
    name: 'subMenu',
    props:{
      item: {
        type: Object,
        default: {}
      }
    },
    computed:{
        font(){
            let item = this.item
            return item.meta && item.meta.font ? item.meta.font : ''
        },
        name(){
            let item = this.item
            return item.meta && item.meta.name ? item.meta.name : ''
        },
        showSubMenu(){
            let item = this.item
            return item.children && item.children.filter(x=>x.meta.show).length
        },
        showMenuItem(){
            let item = this.item
            return (!item.children || !item.children.filter(x=>x.meta.show).length)  && item.meta && item.meta.show
        }
    }
  }
</script>
<style>
    .el-tree-node{
        box-sizing: content-box;
        padding: 2px 0;
    }
</style>
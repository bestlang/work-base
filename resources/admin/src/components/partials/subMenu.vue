<template>
    <div>
          <el-submenu role="submenu" v-if="calType(item)==='el-submenu' && item.meta.show" :index="item.path">
              <template slot="title">
                <i class="if" v-html="item.meta.font"></i>
                <span slot="title">{{item.meta.name}}</span>
              </template>
              <template v-for="child in item.children">
                <sub-menu :item="child" @mouseenter="handleMouseEnter"></sub-menu>
              </template>
          </el-submenu>
          <el-menu-item v-else-if="calType(item)==='el-menu-item' && item.meta.show" :index="item.path">
              <i class="if" v-html="item.meta.font"></i>
              <span slot="title">{{item.meta.name}}</span>
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
    methods:{
        calType(item){
            return item.children && item.children.filter(x=>x.meta.show).length ? 'el-submenu':'el-menu-item'
        },
        handleMouseEnter(el){
            el.target.stopPropagation()
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
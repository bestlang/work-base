<template>
      <div :is="type" :index="item.path" class="unselectable" v-if="item.meta.show">
          <template v-if="type==='el-submenu'">
              <template slot="title">
                <i class="iconfont" v-html="item.meta.font"></i>
                <span slot="title">{{item.meta.name}}</span>
              </template>
              <template v-for="child in item.children">
                <cell :item="child" :type="child.children && child.children.filter(x=>x.meta.show).length? 'el-submenu':'el-menu-item'" @mouseenter="handleMouseEnter"></cell>
              </template>
          </template>
          <template v-if="type==='el-menu-item'" :index="item.path">
              <i class="iconfont" v-html="item.meta.font"></i>
              <span slot="title">{{item.meta.name}}</span>
          </template>
      </div>
</template>

<script>
  // 每一个menu-item都可能是一个submenu
  export default {
    name: 'cell',
    props:{
      item: {
        type: Object,
        default: {}
      },
      type: {
        type: String,
        // default: 'el-submenu'
      }
    },
    methods:{
      handleMouseEnter(el){
        el.target.stopPropagation()
      }
    }
  }
</script>
<style>
    .el-tree-node{
        margin-bottom: 5px;
    }
</style>
<template>
      <div :is="type" :index="item.path" class="unselectable" v-if="item.meta.show">
          <slot></slot>
          <template v-if="type==='el-submenu'">
              <template slot="title">
                <i class="iconfont" v-html="item.meta.font"></i>
                <span slot="title">{{item.meta.name}}</span>
              </template>
              <template v-for="child in item.children">
                <cell :item="child" :type="calType(child)" @mouseenter="handleMouseEnter"></cell>
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
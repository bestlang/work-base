<template>
      <div :is="type" :index="item.path" class="unselectable">
          <template v-if="type==='el-submenu'">
              <template slot="title">
                <i class="iconfont" v-html="item.meta.font"></i>
                <span slot="title">{{item.meta.name}}</span>
              </template>
              <template v-for="child in item.children">
                <cell :item="child" :type="child.children ? 'el-submenu':'el-menu-item'"></cell>
              </template>
          </template>
          <template v-if="type==='el-menu-item' && item.meta.show" :index="item.path">
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
    }
  }
</script>

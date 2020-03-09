<style lang="less">
  .l-tree-containner{
    min-width: 200px;
    padding: 20px;
    border-right: 1px solid #f4f4f4;
    flex-shrink: 0;
  }
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    padding-right: 8px;
  }
</style>
<template>
  <div class="l-tree-containner">
    <el-tree
      @node-click="handleNodeClick"
      icon-class="el-icon-caret-right"
      :default-expand-all="true"
      ref="tree"
      :data="treeData"
      node-key="id"
      :props="customProps"
      :expand-on-click-node="false">
            <span class="custom-tree-node" slot-scope="{ node, data }">
              <span><span v-if="!data.children.length" class="iconfont">&#xe92a;</span>{{ node.label }}</span>
            </span>
    </el-tree>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        customProps: {
          children: 'children',
          label: 'name'
        }
      }
    },
    computed:{
      treeData(){
        return this.$store.getters.channels;
      }
    },
    methods:{
      handleNodeClick(...params){
        this.$emit('nodeClick', params);
      }
    },
    mounted() {
      this.$store.dispatch('toggleState');
      this.$store.dispatch(this.$types.CMS_CHANNELS);
    }
  }
</script>

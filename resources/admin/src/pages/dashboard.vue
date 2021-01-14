<template>
  <div>
    <div v-title="'面板'"></div>
  </div>
</template>
<script>
    const drawerType = {
        node: 0,
        link: 1
    }

    export default {
        data() {
            return {}
        }
    }
</script>
<style lang="less">
  .ellipsis {
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    word-wrap: break-word;
  }
</style>

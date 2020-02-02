<style lang="less">
  .edui-editor div{
  }
</style>
<template>
  <div id="ueditor-wrap">
    <script :id="dynamicId" type="text/plain" style="width:1024px;height:500px;"></script>
  </div>
</template>
<script>
  export default {
    name: 'ueditor',
    data(){
      return {
        ueditor: null,
        dynamicId: 'ueditor_id_' + Math.floor(Math.random() * 123456)
      }
    },
    props: {
      defaultContent: {
        type: String
      },
      config: {
        type: Object
      },
      index: {
        type: String,
        default: 0
      }
    },
    mounted() {
      this.$nextTick(() => {
        this.ueditor = window.UE.getEditor(this.dynamicId, this.config);

        this.ueditor.ready(() => {
          this.ueditor.setContent(this.defaultContent);
          //输入大写字母不能触发contentChange事件,使用keyup作为补充
          this.ueditor.addListener('keyup', () => {
            this.$emit('contentChange', this.ueditor, this.index)
          });
          this.ueditor.addListener('contentChange', () => {
            this.$emit('contentChange', this.ueditor, this.index)
          })
        });
      });
    },
    methods: {
      getUEContent(){
        return this.ueditor.getContent()
      }
    },
    destroyed() {
      this.ueditor.destroy()
    }
  }
</script>

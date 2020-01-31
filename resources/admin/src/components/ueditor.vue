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
      }
    },
    mounted() {
      this.$nextTick(() => {
        this.ueditor = window.UE.getEditor(this.dynamicId, this.config);
        this.ueditor.ready(() => {
          this.$emit('ready', this.ueditor, 0);
          this.ueditor.setContent(this.defaultContent);
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

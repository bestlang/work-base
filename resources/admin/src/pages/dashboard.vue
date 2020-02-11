<template>
  <div>
    <p>welcome,dashboard.</p>
<!--    <el-button @click="getContent">获取内容</el-button>-->
<!--    <p></p>-->
<!--    <p></p>-->
<!--    <vue-ueditor-wrap v-model="content" :config="ueditorConfig"></vue-ueditor-wrap>-->
<!--    <p></p>-->
<!--    <p></p>-->
  </div>

</template>
<script>
  import VueUeditorWrap from 'vue-ueditor-wrap';
  import ueditorConfig from "../store/ueditor";
  export default {
    data(){
      return {
        index: 'some_random_string',
        content: '这是我设置的默认文本...'
      }
    },
    computed: {
      ueditorConfig(){
        return ueditorConfig
      }
    },
    components: {
      VueUeditorWrap
    },
    watch:{
      content(){}
    },
    methods:{
      setUeditor(instance, index){
      },
      getContent(){
        this.content = 'fuck';
      }
    },
    created() {}
  }
</script>

<template>
  <div>
    <p>welcome,dashboard.</p>
    <ueditor :config="config" :default-content="content" @ready="setUeditor" :index="index"></ueditor>
    <el-button @click="getContent">获取内容</el-button>
  </div>

</template>
<script>
  import ueditor from "../components/ueditor";

  export default {
    data(){
      return {
        index: 'some_random_string',
        content: '这是我设置的默认文本...',
        config: {
          initialFrameWidth: 1038,
          initialFrameHeight: 350,
          ZeroClipboard: false
        },
        ueArray:[]
      }
    },
    components: {
      ueditor: ueditor
    },
    methods:{
      setUeditor(instance, index){
        this.ueArray[index] = instance;
      },
      getContent(){
        alert(this.ueArray[0].getContent())
      }
    }
  }
</script>

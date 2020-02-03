<template>
  <div>
    <p>welcome,dashboard.</p>
<!--    <ueditor :config="config" :default-content="content" @ready="setUeditor" :index="index"></ueditor>-->
    <el-button @click="getContent">获取内容</el-button>
    <p></p>
    <p></p>
    <vue-ueditor-wrap v-model="content" :config="myConfig"></vue-ueditor-wrap>
    <p></p>
    <p></p>
  </div>

</template>
<script>
  // import ueditor from "../components/ueditor";
  // import VueUeditorWrap from 'vue-ueditor-wrap/src/components/vue-ueditor-wrap';
  import VueUeditorWrap from 'vue-ueditor-wrap';

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
        myConfig: {
          // 编辑器不自动被内容撑高
          autoHeightEnabled: false,
          // 初始容器高度
          initialFrameHeight: 240,
          // 初始容器宽度
          initialFrameWidth: '100%',
          // 上传文件接口（这个地址是我为了方便各位体验文件上传功能搭建的临时接口，请勿在生产环境使用！！！）
          serverUrl: '',
          // UEditor 资源文件的存放路径，如果你使用的是 vue-cli 生成的项目，通常不需要设置该选项，vue-ueditor-wrap 会自动处理常见的情况，如果需要特殊配置，参考下方的常见问题2
          UEDITOR_HOME_URL: '/static/UEditor/'
        }
      }
    },
    components: {
      // ueditor: ueditor,
      VueUeditorWrap
    },
    watch:{
      content(){
        alert(this.content)
      }
    },
    methods:{
      setUeditor(instance, index){
        this.ueArray[index] = instance;
      },
      getContent(){
        this.content = 'fuck';
        alert(this.ueArray[0].getContent())
      }
    }
  }
</script>

<style lang="less" scoped>
  .l-content-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 50px - 20px);
    margin:-20px 0 -20px -20px;
    overflow-x: hidden;
    .l-tree-content{
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-flow: row nowrap;
      box-sizing: border-box;
      width: calc(100% - 240px);
    }
  }
</style>
<template>
  <div class="l-content-list">
    <channel-tree @nodeClick="handleNodeClick"></channel-tree>
    <div class="l-tree-content">
      <div v-if="!showForm">
        <el-button type="primary" size="small" @click="addContent">添加</el-button>
      </div>
      <div v-if="showForm && selectedModel">
        <el-form>
          <template v-for="(item, index) in selectedModel.fields">
              <el-form-item v-if="item.type=='text'" :label="item.label"><el-input :key="index" :name="item.field" v-model="form[item.field]"></el-input></el-form-item>
              <div v-if="item.type=='content'" class="l-mb-22">
                  <label>{{item.label}}</label>
                  <ueditor :config="config" :key="index" :default-content="form[item.field]" @contentChange="handleContentChange" :index="item.field"></ueditor>
              </div>
          </template>
          <el-form-item>
            <el-button @click="handleSubmit">提交</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>
<script>
  import channelTree from "./components/channelTree";
  import ueditor from "../../components/ueditor";
  export default {
    data() {
      return {
        selectedChannel: null,
        selectedModel: null,
        showForm: false,
        config: {
          // initialFrameWidth: 1038,
          // initialFrameHeight: 350,
          // ZeroClipboard: false
        },
        form:{}
      }
    },
    components:{
      'channel-tree': channelTree,
      ueditor: ueditor
    },
    computed:{
      contents(){
      }
    },
    methods: {
      handleSubmit(){
        this.$set(this.form, 'model_id', this.selectedModel.id);
        this.$set(this.form, 'channel_id', this.selectedChannel.id)
        //alert(JSON.stringify(this.form));
        this.$http
          .post("/admin/cms/content/save", this.form)
          .then(res => {
            alert(JSON.stringify(res));
          });
      },

      handleContentChange(instance, index){
        this.form[index] = instance.getContent()
        console.log(`------------------:`, JSON.stringify(this.form));
      },
      handleNodeClick(...params){
        this.showForm = false;
        let channel = params[0][0];
        this.selectedChannel = channel;
        // let channelId = channel.id;
        // let channelName = channel.name;
        // let channelModelId = channel.model_id;
        // let channelTitle = channel.title;
        // emit get contents action
      },
      addContent(){
        this.showForm = true;
        this.loadModel(this.selectedChannel.model_id)
      },
      loadModel(id){
        this.$http
          .get("/admin/cms/model/get", {params: {id}})
          .then(res => {
            this.selectedModel = res.data;
            for(let idx in this.selectedModel.fields){
              let item = this.selectedModel.fields[idx];
              this.$set(this.form, item.field, '');
            }
          });
      },
    },
    mounted() {
    }
  }
</script>


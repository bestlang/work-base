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
        <div class="l-block" v-if="!showForm">
          <div class="l-block-header">
            <el-button type="primary" size="small" @click="addContent">添加</el-button>
          </div>
          <div class="l-block-body">
            <el-table
              :data="contents"
              style="width: 100%">
              <el-table-column
                prop="id"
                label="ID">
              </el-table-column>
              <el-table-column
                prop="title"
                label="标题">
              </el-table-column>
              <el-table-column
                prop="channel.name"
                label="栏目">
              </el-table-column>
              <el-table-column
                label="操作">
                <template slot-scope="scope">
                  <el-button type="text" @click="editContent(scope.row)">编辑</el-button>
                  <el-button type="text" @click="deleteContent(scope.row)">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </div>
      <div class="l-block" v-if="showForm && selectedModel">
        <div class="l-block-header">添加表单</div>
        <div class="l-block-body">
          <el-form label-width="100px">
            <template v-for="(item, index) in selectedModel.fields">
              <el-form-item v-if="item.type=='text'" :label="item.label">
                <el-input :key="index" :name="item.field" v-model="form[item.field]"></el-input>
              </el-form-item>
              <el-form-item v-if="item.type=='textarea'" :label="item.label">
                <el-input type="textarea" v-model="form[item.field]"></el-input>
              </el-form-item>
              <el-form-item v-if="item.type=='content'" class="l-mb-22" :label="item.label">
<!--                <label>{{item.label}}</label>-->
                <div>
                  <vue-ueditor-wrap v-model="form[item.field]" :config="ueditorConfig"></vue-ueditor-wrap>
                </div>
              </el-form-item>
            </template>
            <el-form-item>
              <el-button @click="saveContent">提交</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import channelTree from "./components/channelTree";
  import VueUeditorWrap from 'vue-ueditor-wrap';
  import ueditorConfig from "../../store/ueditor";

  export default {
    data() {
      return {
        selectedChannel: null,
        selectedModel: null,
        contents: [],
        showForm: false,
        form:{}
      }
    },
    components:{
      'channel-tree': channelTree,
      VueUeditorWrap
    },
    computed:{
      ueditorConfig(){
        return ueditorConfig
      }
    },
    watch:{
      selectedChannel(val, oldVal){
        this.loadContents()
      },
      showForm(){
        this.$store.dispatch('collapse');
      }
    },
    methods: {
      editContent(row){
        console.log(`>>>>>>>>>>>>>>>>>..`,JSON.stringify(row))
        this.selectedChannel = row.channel;
        this.loadModel(this.selectedChannel.model_id)
        this.showForm = true;
        this.loadWholeContent(row)
      },
      deleteContent(row){

      },
      saveContent(){
        if(!this.form.channel_id && !this.form.model_id){
          this.$set(this.form, 'model_id', this.selectedModel.id);
          this.$set(this.form, 'channel_id', this.selectedChannel.id)
        }
        this.$http
          .post("/admin/cms/content/save", this.form)
          .then(res => {
            if(res.success){
              this.$message({
                type: 'success',
                message: '添加成功!'
              });
              this.showForm = false;
              this.loadContents();
              this.form = {}
            }
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
              // 重置表单
              this.$set(this.form, item.field, '');
            }
          });
      },
      loadContents(){
        let channel_id = 0;
        if(this.selectedChannel){
          channel_id = this.selectedChannel.id
        }
        this.$http
          .get("/admin/cms/contents", {params: {channel_id}})
          .then(res => {
            this.contents = res.data;
          });
      },
      loadWholeContent({id}){
        this.$http
          .get("/admin/cms/content/whole", {params: {id}})
          .then(res => {
            let model = res.data;

            let contentFields = ['channel_id', 'model_id', 'title', 'keywords', 'description'];
            let contentContentFields = [];
            let metaFields = [];

            this.$set(this.form, 'id', id);

            contentFields.forEach( field => {this.$set(this.form, field, model[field])} );

            if(model.contents && model.contents.length){
              model.contents.forEach( item => {this.$set(this.form, item.field, item.value)} );
            }

            if(model.metas && model.metas.length){
              model.metas.forEach( item => {this.$set(this.form, item.field, item.value)});
            }

            console.log(`********************____>`, JSON.stringify(this.form));
            console.log(`<<<<<<<<<<<<<<<<<<<:`, JSON.stringify(res));
          });
      }
    },
    mounted() {
      this.loadContents()
      this.$store.dispatch('collapse');
    }
  }
</script>


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
          <div class="l-block-header" v-if="parentChannel">
            <div><i class="iconfont">&#xe64c;</i> {{parentChannel.hasOwnProperty('name') ? parentChannel.name : ''}}</div>
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
      <div class="l-block" v-if="showForm && currentModel">
        <div class="l-block-header">
          <div>
            <span class="l-go-back" @click="goback"><span class="iconfont">&#xe601;</span>返回</span>
            <el-divider direction="vertical"></el-divider>
            <span>在「<i class="iconfont">&#xe64c;</i>{{currentChannel.name}}」下{{formTitle}}</span>
          </div>
        </div>
        <div class="l-block-body">
          <el-form label-width="100px">
            <template v-for="(item, index) in currentModel.fields">
              <el-form-item v-if="item.type=='text'" :label="item.label">
                <el-input :key="index" :name="item.field" v-model="form[item.field]"></el-input>
              </el-form-item>
              <el-form-item v-if="item.type=='checkbox'" :label="item.label">
                <el-checkbox-group v-model="form[item.field]">
                  <el-checkbox :label="option.value" v-for="option in item.extra">{{option.name}}</el-checkbox>
                </el-checkbox-group>
              </el-form-item>
              <el-form-item v-if="item.type=='textarea'" :label="item.label">
                <el-input type="textarea" v-model="form[item.field]"></el-input>
              </el-form-item>
              <el-form-item v-if="item.type=='content'" class="l-mb-22" :label="item.label">
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
        contents: [],
        showForm: false,
        formTitle: '添加文章',
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
      },
      parentChannel(){
        return this.$store.getters.parentChannel;
      },
      currentChannel(){
        return this.$store.getters.currentChannel
      },
      currentModel(){
        return this.$store.getters.currentModel
      }
    },
    watch:{
      currentChannel(val, oldVal){
        this.loadContents()
      },
      showForm(){
        this.$store.dispatch('collapse');
      }
    },
    methods: {
      goback(){
        this.showForm = false;
      },
      editContent(row){
        this.formTitle = '编辑文章';
        this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, row.channel);
        this.loadModel(row.channel.model_id)
        this.showForm = true;
        this.loadWholeContent(row)
      },
      deleteContent(row){
        this.$confirm('确定删除文章?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$http
            .post("/admin/cms/content/delete", {id: row.id})
            .then(res => {
              this.$message({
                type: 'success',
                message: '删除成功!'
              });
              this.loadContents()
            }).catch(()=>{});
        });
      },
      saveContent(){
        if(!this.form.channel_id && !this.form.model_id){
          this.$set(this.form, 'model_id', this.currentModel.id);
          this.$set(this.form, 'channel_id', this.currentChannel.id)
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

      handleNodeClick(node, ...params){
        this.showForm = false;
        let channel = node[0]
        this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, channel);
        this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, node[0])
      },
      addContent(){
        this.showForm = true;
        this.formTitle = '添加文章';
        this.loadModel(this.currentChannel.model_id)
      },
      loadModel(id){
        this.$http
          .get("/admin/cms/model/get", {params: {id}})
          .then(res => {
            let currentModel = res.data;
            // 过滤掉模型中属于栏目的字段
            currentModel.fields = currentModel.fields.filter(item => { return !item.is_channel })
            this.$store.dispatch(this.$types.CMS_CURRENT_MODEL, currentModel)
            for(let idx in this.currentModel.fields){
              let item = this.currentModel.fields[idx];
                // 重置表单
                this.$set(this.form, item.field, '');
            }
          });
      },
      loadContents(){
        let channel_id = 0;
        if(this.currentChannel){
          channel_id = this.currentChannel.id
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
            let content = res.data;

            let contentFields = ['channel_id', 'model_id', 'title', 'keywords', 'description'];

            this.$set(this.form, 'id', id);

            contentFields.forEach( field => {this.$set(this.form, field, content[field])} );

            if(content.contents && content.contents.length){
              content.contents.forEach( item => {this.$set(this.form, item.field, item.value)} );
            }

            if(content.metas && content.metas.length){
              content.metas.forEach(
                item => {
                  this.$set(this.form, item.field, item.value);
                });
            }

          });
      }
    },
    mounted() {
      this.loadContents()
      this.$store.dispatch('collapse');
    }
  }
</script>


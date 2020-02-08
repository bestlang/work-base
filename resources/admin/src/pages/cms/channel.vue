<style lang="less" scoped>
  .l-channel-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 50px - 20px);
    margin:-20px 0 -20px -20px;
    overflow-x: hidden;
    .l-tree-containner{
      min-width: 200px;
      padding: 20px;
      border-right: 1px solid #f4f4f4;
      flex-shrink: 0;
    }
    .l-tree-content{
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-flow: row nowrap;
      box-sizing: border-box;
      width: calc(100% - 240px);
    }
  }
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    padding-right: 8px;
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
  .l-channel-form{width: 100%;}
  .l-channel-info ul li{
    line-height: 40px;
  }
</style>
<template>
  <div class="l-channel-list">
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
      <div class="l-tree-content" v-if="showChannelChildren">
        <div class="l-block">
            <div class="l-block-header"  v-if="parentChannel && parentChannel.id">
                <span><i class="iconfont">&#xe64c;</i> {{parentChannel.hasOwnProperty('name') ? parentChannel.name : ''}}</span>
                <el-button-group>
                  <el-button style="padding: 3px 10px" type="text" @click="editChannel(parentChannel)">编辑</el-button>
                  <el-button style="padding: 3px 10px" type="text" @click="addChannel(parentChannel)">新增子栏目</el-button>
                </el-button-group>
            </div>
            <div class="l-block-header" v-else>
              <el-button style="padding: 3px 10px" type="text" @click="addChannel({id: 0})">新增栏目</el-button>
            </div>
            <div class="l-block-body">
              <el-table
                v-loading="loading"
                :data="children"
                style="width: 100%">
                <el-table-column
                  prop="id"
                  label="ID"
                  width="100">
                </el-table-column>
                <el-table-column
                  prop="name"
                  label="栏目名">
                </el-table-column>
                <el-table-column
                  width="300"
                  label="操作">
                  <template slot-scope="scope">
                    <el-button type="text" @click="editChannel(scope.row)">编辑</el-button>
                    <el-button type="text" @click="addChannel(scope.row)">新增子栏目</el-button>
                    <el-button type="text" @click="deleteChannel(scope.row)">删除</el-button>
                  </template>
                </el-table-column>
              </el-table>
            </div>
        </div>
      </div>
      <div class="l-tree-content" v-if="!showChannelChildren">
        <div class="l-block" v-if="!showChannelChildren">
          <div class="l-block-header" v-if="parentChannel && parentChannel.id">
              <span>
                <span v-if="channelForm.id"><i class="iconfont">&#xe64c;</i> {{channelForm.name}}</span>
                <span v-else>
                  在"<i class="iconfont">&#xe64c;</i> {{parentChannel.name}}"下新增栏目
                </span>
              </span>
              <el-button-group>
                <el-button style="padding: 3px 10px" type="text" @click="addChannel(channelForm)">新增子栏目</el-button>
                <el-button style="padding: 3px 10px" type="text" @click="deleteChannel(channelForm)">删除</el-button>
              </el-button-group>
          </div>
          <div class="l-block-body">
            <el-form :model="channelForm" label-width="100px">
              <el-form-item label="模型">
                <el-select v-model="channelForm.model_id" placeholder="请选择">
                  <el-option
                    v-for="m in models"
                    :key="m.name"
                    :label="m.name"
                    :value="m.id">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="栏目名">
                <el-input v-model="channelForm.name" autocomplete="off"></el-input>
              </el-form-item>
              <template v-for="(item, index) in customChannelFields">
                <el-form-item v-if="item.type=='text'" :label="item.label">
                  <el-input :key="index" :name="item.field" v-model="channelForm[item.field]"></el-input>
                </el-form-item>
                <el-form-item v-if="item.type=='textarea'" :label="item.label">
                  <el-input type="textarea" v-model="channelForm[item.field]"></el-input>
                </el-form-item>
                <el-form-item v-if="item.type=='content'" class="l-mb-22" :label="item.label">
                  <div>
                    <vue-ueditor-wrap v-model="channelForm[item.field]" :config="ueditorConfig"></vue-ueditor-wrap>
                  </div>
                </el-form-item>
              </template>
              <el-form-item>
                <el-button type="primary" @click="doSubmit">确 定</el-button>
                <el-button @click="doCancel">取 消</el-button>
              </el-form-item>
            </el-form>
          </div>
        </div>
      </div>
  </div>
</template>
<script>
  import ueditorConfig from "../../store/ueditor";
  import VueUeditorWrap from 'vue-ueditor-wrap';


  export default {
    data() {
      return {
        customProps: {
          children: 'children',
          label: 'name'
        },
        title: '添加子栏目',
        showChannelChildren: true,
        channelForm:{
          id: null,
          model_id: '',
          parent_id: null,
          name: null,
        },
        customChannelFields: []
      }
    },
    components:{
      VueUeditorWrap
    },
    computed:{
      loading(){
        return this.$store.getters.loading;
      },
      treeData(){
        return this.$store.getters.channels;
      },
      children(){
        return this.$store.getters.channelChildren;
      },
      models(){
        return this.$store.getters.models;
      },
      parentChannel(){
        return this.$store.getters.parentChannel;
      },
      ueditorConfig(){
        return ueditorConfig
      }
    },
    methods: {
      addChannel(row){
        this.showChannelChildren = false;
        this.channelForm = Object.assign({}, {
          id: null,
          parent_id: row.id,
          model_id: '',
          channel_id: null,
          name: null
        });
        this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, row)
        this.customChannelFields = []
      },
      editChannel(row){
        this.loadWholeChannel(row)
        this.showChannelChildren = false;

        this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, row)
      },
      deleteChannel(row){
        this.$confirm('确定删除本栏目?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$http
            .post("/admin/cms/channel/delete", {id: row.id})
            .then(res => {
              if(res.success){
                this.$store.dispatch(this.$types.CMS_CHANNELS, {id: row.parent_id});
                this.showChannelChildren = true;
                this.$message({
                  type: 'success',
                  message: '删除成功!'
                });
              }else{
                this.$message({
                  type: 'error',
                  message: res.error
                });
              }

            }).catch(()=>{});
        }).catch(()=>{});
      },
      handleNodeClick(node, ...$params){
        if(node.children.length>0){
          this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, node);
          this.showChannelChildren = true;
          this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, node)
        }else{
          this.showChannelChildren = false;
          this.loadWholeChannel(node)
        }
      },
      doSubmit(){
        if(!this.channelForm.id){
          this.doAdd()
        }else{
          this.doEdit()
        }
      },
      doCancel(){
        this.showChannelChildren = true;
      },
      doAdd(){
        this.showChannelChildren = false
        this.$http
          .post("/admin/cms/channel/save", this.channelForm)
          .then(res => {
            if(res.success){
              this.showChannelChildren = true;
              this.$store.dispatch(this.$types.CMS_CHANNELS, this.parentChannel);
              this.$message({
                type: 'success',
                message: '添加成功!'
              });
            }else{
              this.$message({
                type: 'error',
                message: res.error
              });
            }
          });
      },
      doEdit(){
        this.$http
          .post("/admin/cms/channel/save", this.channelForm)
          .then(res => {
            if(res.success){
              this.$message({
                type: 'success',
                message: '修改成功!'
              });
              this.$store.dispatch(this.$types.CMS_CHANNELS, {id: this.channelForm.parent_id});
            }else{
              this.$message({
                type: 'warning',
                message: '修改失败!'+res.error
              });
            }
          });
      },
      loadWholeChannel({id}){
        this.$http
          .get("/admin/cms/channel/whole", {params: {id}})
          .then(res => {
            let whole = res.data;
            this.channelForm = {}
            let baseFields = ['id', 'model_id', 'parent_id', 'name', 'title', 'keywords', 'description'];

            baseFields.forEach( field => {this.$set(this.channelForm, field, whole[field])} );

            if(whole.contents && whole.contents.length){
              whole.contents.forEach( item => {this.$set(this.channelForm, item.field, item.value)} );
            }

            if(whole.metas && whole.metas.length){
              whole.metas.forEach( item => {this.$set(this.channelForm, item.field, item.value)});
            }

          });
      }
    },
    mounted() {
      this.$store.dispatch('toggleState');
      this.$store.dispatch(this.$types.CMS_CHANNELS);
      this.$store.dispatch(this.$types.CMS_MODELS);
    },
    watch:{
      ['channelForm.model_id'](val, oldVal){
        if(val){
          if(this.models.length > 0){
            this.models.forEach( model => {
              if(model.id == this.channelForm.model_id){
                this.customChannelFields = model.fields.filter( field => {
                  if(field.is_channel){
                    // 不覆盖主表中存储的字段
                    if(!this.channelForm.hasOwnProperty(field.field)){
                      this.$set(this.channelForm, field.field, '')
                    }
                  }
                  return field.is_channel;
                })
              }
            });
          }
        }else{
          // 不设置任何自定义表单项
          this.customChannelFields = []
        }
      }
    }
  }
</script>


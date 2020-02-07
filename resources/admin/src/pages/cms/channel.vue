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
      <div class="l-tree-content">
        <div class="l-block" v-if="showChannelChildren">
          <div class="l-block-header">
            <span><i class="iconfont">&#xe64c;</i> {{parentChannel&&parentChannel.hasOwnProperty('name') ? parentChannel.name : ''}}</span>
            <el-button-group>
              <el-button style="padding: 3px 10px" type="text" @click="editChannel(parentChannel)">编辑</el-button>
              <el-button style="padding: 3px 10px" type="text" @click="addChannel(parentChannel)">新增子栏目</el-button>
            </el-button-group>
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

        <div class="l-block l-channel-info" v-if="!showChannelChildren">
          <div class="l-block-header">
            <span><i class="iconfont">&#xe64c;</i> {{channelForm.name}}</span>
            <el-button-group>
              <el-button style="padding: 3px 10px" type="text" @click="editChannel(channelForm)">编辑</el-button>
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
<!--              <el-form-item label="标题">-->
<!--                <el-input v-model="channelForm.title" autocomplete="off"></el-input>-->
<!--              </el-form-item>-->
<!--              <el-form-item label="关键词">-->
<!--                <el-input v-model="channelForm.keywords" autocomplete="off"></el-input>-->
<!--              </el-form-item>-->
<!--              <el-form-item label="描述">-->
<!--                <el-input type="textarea" v-model="channelForm.description" autocomplete="off"></el-input>-->
<!--              </el-form-item>-->
              <template v-for="(item, index) in channelFields">
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
<!--    <el-dialog :title="title" :visible.sync="showChannelForm">-->
<!--      <el-form :model="channelForm" label-width="100px">-->
<!--        <el-form-item label="模型">-->
<!--          <el-select v-model="channelForm.model_id" placeholder="请选择">-->
<!--            <el-option-->
<!--              v-for="m in models"-->
<!--              :key="m.name"-->
<!--              :label="m.name"-->
<!--              :value="m.id">-->
<!--            </el-option>-->
<!--          </el-select>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="栏目名">-->
<!--          <el-input v-model="channelForm.name" autocomplete="off"></el-input>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="标题">-->
<!--          <el-input v-model="channelForm.title" autocomplete="off"></el-input>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="关键词">-->
<!--          <el-input v-model="channelForm.keywords" autocomplete="off"></el-input>-->
<!--        </el-form-item>-->
<!--        <el-form-item label="描述">-->
<!--          <el-input v-model="channelForm.description" autocomplete="off"></el-input>-->
<!--        </el-form-item>-->
<!--        <el-form-item>-->
<!--          <el-button type="primary" @click="doSubmit">确 定</el-button>-->
<!--          <el-button @click="doCancel">取 消</el-button>-->
<!--        </el-form-item>-->
<!--      </el-form>-->
<!--    </el-dialog>-->
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
        showChannelForm: false,
        channelForm:{
          id: '',
          parent_id: '',
          name: '',
          model_id: ''
        },
        channelFields: []
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
        this.showChannelForm = true;
        Object.assign(this.channelForm, {
          id: '',
          parent_id: row.id,
          name: ''
        });
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
          console.log(`+++++++++++++++++++`, JSON.stringify(node))
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
        this.showChannelForm = false;
      },
      doAdd(){
        this.showChannelChildren = false
        this.$http
          .post("/admin/cms/channel/add", this.channelForm)
          .then(res => {
            if(res.success){
              this.showChannelForm = false;
              this.showChannelChildren = true;
              this.$store.dispatch(this.$types.CMS_CHANNELS, {id: this.channelForm.parent_id});
              this.$message({
                type: 'success',
                message: '添加成功!'
              });
              this.showChannelForm = false
            }else{
              this.$message({
                type: 'error',
                message: res.error
              });
              this.showChannelChildren = true
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
              this.showChannelChildren = false;
              this.showChannelForm = false
            }else{
              this.$message({
                type: 'warning',
                message: '修改失败!'
              });
            }
          });
      },
      loadWholeChannel({id}){
        this.$http
          .get("/admin/cms/channel/whole", {params: {id}})
          .then(res => {
            let model = res.data;
            this.channelForm = {}
            let channelFields = ['id', 'model_id', 'parent_id', 'name', 'title', 'keywords', 'description'];

            this.$set(this.channelForm, 'id', id);

            channelFields.forEach( field => {this.$set(this.channelForm, field, model[field])} );

            if(model.contents && model.contents.length){
              model.contents.forEach( item => {this.$set(this.channelForm, item.field, item.value)} );
            }

            if(model.metas && model.metas.length){
              model.metas.forEach( item => {this.$set(this.channelForm, item.field, item.value)});
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
      ['channelForm.model_id'](){
        console.log(this.channelForm.model_id, '------------------', JSON.stringify(this.models.length));
        if(this.models.length > 0){
          this.models.forEach( model => {
            if(model.id == this.channelForm.model_id){
              this.channelFields = model.fields.filter( field => {
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
      }
    }
  }
</script>


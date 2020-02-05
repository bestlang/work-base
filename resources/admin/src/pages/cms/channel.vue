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
            <span><i class="iconfont">&#xe64c;</i> {{parentChannel.name}}</span>
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
                  <el-button type="text">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
      </div>

        <div class="l-block l-channel-info" v-if="!showChannelChildren">
          <div class="l-block-header">
            <span><i class="iconfont">&#xe92a;</i>{{channelForm.name}}</span>
            <el-button-group>
              <el-button style="padding: 3px 10px" type="text" @click="editChannel(channelForm)">编辑</el-button>
              <el-button style="padding: 3px 10px" type="text" @click="deleteChannel(channelForm)">删除</el-button>
            </el-button-group>
          </div>
          <div class="l-block-body">
            <ul>
              <li>编号: <span>{{channelForm.id}}</span></li>
              <li>栏目名: <span>{{channelForm.name}}</span></li>
              <li>模型: <span>{{channelForm.model.name}}</span></li>
              <li>标题: <span>{{channelForm.title}}</span></li>
              <li>关键词: <span>{{channelForm.keywords}}</span></li>
              <li>描述: <span>{{channelForm.description}}</span></li>
            </ul>
          </div>
        </div>
      </div>
    <el-dialog :title="title" :visible.sync="showChannelForm">
      <el-form :model="channelForm" label-width="100px">
        <el-form-item label="栏目名">
          <el-input v-model="channelForm.name" autocomplete="off"></el-input>
        </el-form-item>
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
        <el-form-item label="标题">
          <el-input v-model="channelForm.title" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="关键词">
          <el-input v-model="channelForm.keywords" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="描述">
          <el-input v-model="channelForm.description" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="doSubmit">确 定</el-button>
          <el-button @click="doCancel">取 消</el-button>
        </el-form-item>
      </el-form>
    </el-dialog>
  </div>
</template>
<script>
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
        // 暂存父栏目
        // parentChannel: {
        //   id: '',
        //   parent_id: '',
        //   name: '',
        //   model_id: '',
        //   title: '',
        //   keywords: '',
        //   description: '',
        // },
        channelForm:{
          id: '',
          parent_id: '',
          name: '',
          model_id: '',
          title: '',
          keywords: '',
          description: '',
        }
      }
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
      }
    },
    methods: {
      addChannel(row){
        this.showChannelForm = true;
        Object.assign(this.channelForm, {
          id: '',
          parent_id: row.id,
          name: '',
          title: '',
          keywords: '',
          description: '',
        });
      },
      editChannel(row){
        this.showChannelForm = true;
        this.title = '编辑栏目';
        Object.assign(this.channelForm, row);
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
                ///this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, {id: row.parent_id});
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
        });
      },
      handleNodeClick(node, ...$params){
        if(node.children.length>0){
          this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, node);
          this.showChannelChildren = true;
          //Object.assign(this.parentChannel, node);
          this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, node)
        }else{
          ///this.$store.commit(this.$types.CMS_CHANNEL_CHILDREN, [])
          this.showChannelChildren = false;
          console.log(`--------------node:`,node);
          Object.assign(this.channelForm, node)
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
        // this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, {id:this.channelForm.parent_id});
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
              ///this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, {id:this.channelForm.parent_id});
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
          .post("/admin/cms/channel/update", this.channelForm)
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

            }
          });
      },
    },
    mounted() {
      this.$store.dispatch('toggleState');
      this.$store.dispatch(this.$types.CMS_CHANNELS);
      this.$store.dispatch(this.$types.CMS_MODELS);
    }
  }
</script>


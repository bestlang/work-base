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
        <el-table
          v-if="!showChannelForm"
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
              <el-button type="text">编辑</el-button>
              <el-button type="text" @click="addChannel(scope.row)">新增</el-button>
              <el-button type="text">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
        <div class="l-channel-form" v-if="showChannelForm">
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
        </div>
      </div>
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
        current:null,
        title: '添加子栏目',
        showChannelForm: false,
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
        })
      },
      handleNodeClick(node, ...$params){
        if(node.children.length>0){
          this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, node);
          this.showChannelForm = false;
        }else{
          this.$store.commit(this.$types.CMS_CHANNEL_CHILDREN, [])
          this.showChannelForm = true;
          Object.assign(this.channelForm, node)
        }
      },
      edit(data){
        this.current = data
        let id = data.id;
        let parent_id = data.parent_id;
        let name = data.name;
        let show_name = data.show_name;
        this.channelForm = {
          id,
          parent_id,
          name,
          show_name
        }
        this.dialogFormVisible = true;
        this.title = '编辑权限';
      },
      add(data) {
        this.current = null;
        this.channelForm = {
          id: '',
          parent_id: '',
          name: ''
        }
        this.current = data;
        this.dialogFormVisible = true;
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
        this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, {id:this.channelForm.parent_id});
      },
      doAdd(){
        const newChild = {name: this.channelForm.name,  children: [] };
        if (!this.current.children) {
          this.$set(this.current, 'children', []);
        }
        this.showChannelForm = false
        this.$http
          .post("/admin/cms/channel/add", {parent_id: this.current.id, name: this.channelForm.name})
          .then(res => {
            newChild.id = res.data.id;
            this.current.children.push(newChild);
            if(res.success){
              this.$message({
                type: 'success',
                message: '添加成功!'
              });
              this.recovery()
            }else{
              this.showChannelForm = true
            }
          });
      },
      doEdit(){
        this.$http
          .post("/admin/cms/channel/update", this.channelForm)
          .then(res => {
            this.$message({
              type: 'success',
              message: '修改成功!'
            });
            // this.loadChildren({id:this.channelForm.parent_id});
            this.$store.dispatch(this.$types.CMS_CHANNEL_CHILDREN, {id:this.channelForm.parent_id});
            this.showChannelForm = false;
          });
      },
      remove(node, data) {
        this.$confirm('删除权限存在风险,是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          this.$http
            .post("/admin/privileges/delete/permission", {id: data.id})
            .then(res => {
              const parent = node.parent;
              const children = parent.data.children || parent.data;
              const index = children.findIndex(d => d.id === data.id);
              children.splice(index, 1);
              this.$message({
                type: 'success',
                message: '删除成功!'
              });
            }).catch(()=>{});
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
</style>

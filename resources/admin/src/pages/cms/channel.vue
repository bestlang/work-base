<template>
  <div class="l-channel-list">
      <div class="l-tree-containner">
        <el-tree
          @node-click="handleNodeClick"
          icon-class="el-icon-caret-right"
          :default-expand-all="true"
          :empty-text="emptyText"
          ref="tree"
          :data="treeData"
          node-key="id"
          :props="customProps"
          :expand-on-click-node="false">
          <span class="custom-tree-node" slot-scope="{ node, data }">
            <span><span v-if="!data.children.length" class="iconfont">&#xe92a;</span>{{ node.label }}</span>
            <span>
<!--              <el-button-->
<!--                type="text"-->
<!--                size="mini"-->
<!--                @click="() => edit(data)">-->
<!--                编辑-->
<!--              </el-button>-->
<!--              <el-button-->
<!--                type="text"-->
<!--                size="mini"-->
<!--                @click="() => add(data)">-->
<!--                新增-->
<!--              </el-button>-->
<!--              <el-button-->
<!--                type="text"-->
<!--                size="mini"-->
<!--                @click="() => remove(node, data)">-->
<!--                删除-->
<!--              </el-button>-->
            </span>
          </span>
        </el-tree>
      </div>
      <div class="l-tree-content">
        <el-table
          v-if="children.length"
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
              <el-button type="text">新增</el-button>
              <el-button type="text">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
        <div class="l-channel-form" v-else>
          <el-form :model="form" label-width="100px">
            <el-form-item label="栏目名">
              <el-input v-model="form.name" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="标题">
              <el-input v-model="form.title" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="关键词">
              <el-input v-model="form.keywords" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item label="描述">
              <el-input v-model="form.description" autocomplete="off"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="doSubmit">确 定</el-button>
              <el-button @click="dialogFormVisible = false">取 消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    <el-dialog :title="title" :visible.sync="dialogFormVisible">
      <el-form :model="form" label-width="100px">
        <el-form-item label="栏目名">
          <el-input v-model="form.name" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button>取 消</el-button>
        <el-button type="primary" @click="doSubmit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        emptyText: 'loading...',
        customProps: {
          children: 'children',
          label: 'name'
        },
        treeData:[],
        children:[],
        current:null,
        dialogFormVisible: false,
        title: '添加子栏目',
        form:{
          id: '',
          parent_id: '',
          name: '',
          title: '',
          keywords: '',
          description: '',
        }
      }
    },
    methods: {
      loadChildren(node){
        this.$http
          .post("/admin/cms/channel/children", {parent_id: node.id})
          .then(res => {
            this.children = res.data
          });
      },
      handleNodeClick(node, ...$params){
        console.log(`****************node:`, node)
        if(node.children.length>0){
          this.loadChildren(node);
        }else{
          this.children = [];
        }
        Object.assign(this.form, node)
      },
      edit(data){
        this.current = data
        let id = data.id;
        let parent_id = data.parent_id;
        let name = data.name;
        let show_name = data.show_name;
        this.form = {
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
        this.form = {
          id: '',
          parent_id: '',
          name: ''
        }
        this.current = data;
        this.dialogFormVisible = true;
      },
      doSubmit(){
        if(!this.form.id){
          this.doAdd()
        }else{
          this.doEdit()
        }
      },
      doAdd(){
        const newChild = {name: this.form.name,  children: [] };
        if (!this.current.children) {
          this.$set(this.current, 'children', []);
        }
        this.dialogFormVisible = false
        this.$http
          .post("/admin/cms/channel/add", {parent_id: this.current.id, name: this.form.name})
          .then(res => {
            newChild.id = res.data.id;
            this.current.children.push(newChild);
            // this.dialogFormVisible = false
            if(res.success){
              this.$message({
                type: 'success',
                message: '添加成功!'
              });
              this.recovery()
            }else{
              this.dialogFormVisible = true
            }

          });
      },
      doEdit(){
        this.$http
          .post("/admin/cms/channel/update", this.form)
          .then(res => {
            this.$message({
              type: 'success',
              message: '修改成功!'
            });
            this.loadChildren({id:this.form.parent_id});
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
      loadChannelsTree(){
        this.$http
          .get("/admin/cms/channel/tree", {params:{disabled: true}})
          .then(res => {
            console.log(`------------------>`,res)
            this.treeData = [res.data[Object.keys(res.data)[0]]];
            this.loadChildren(res.data[Object.keys(res.data)[0]])
          });
      }
    },
    mounted() {
      this.$store.dispatch('toggleState');
      this.loadChannelsTree()
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
    font-size: 14px;
    padding-right: 8px;
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
</style>

<template>
  <div>
    <div v-title="'权限管理'"></div>
    <!--<div class="top-buttons" style="display: flex;flex-flow: row nowrap; justify-content: space-between;">-->
<!--      <div>所有权限</div>-->
    <!--</div>-->
    <div style="width:50%;">
      <div class="l-block">
        <div class="l-block-header">所有权限</div>
        <div class="l-block-body">
          <el-tree
        :empty-text="emptyText"
        ref="tree"
        :data="treeData"
        :default-expanded-keys="[]"
        :default-expand-all="true"
        node-key="id"
        :props="customProps"
        :default-checked-keys="[]"
        @check="handleCheckChange"
        :expand-on-click-node="false">
        <span class="custom-tree-node" slot-scope="{ node, data }">
          <span><span v-if="!data.children.length" class="iconfont">&#xe92a;</span>{{ node.label }}</span>
<!--          -{{ data.id }}-->
          <span>
            <el-button
              type="text"
              size="mini"
              @click="() => edit(data)">
              编辑
            </el-button>
            <el-button
              type="text"
              size="mini"
              @click="() => add(data)">
              新增
            </el-button>
            <el-button
              type="text"
              size="mini"
              @click="() => remove(node, data)">
              删除
            </el-button>
          </span>
        </span>
      </el-tree>
        </div>
      </div>
    </div>
    <el-dialog :title="title" :visible.sync="formVisible"  :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-form-item label="权限显示名">
          <el-input v-model="form.show_name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="权限字符串">
          <el-input v-model="form.name" autocomplete="off" :disabled="form.id>0"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="formVisible = false">取 消</el-button>
        <el-button type="primary" @click="doSubmit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import api from '../../api/index'
  export default {
    data() {
      return {
        emptyText: 'loading...',
        customProps: {
          children: 'children',
          label: 'show_name'
        },
        treeData:[],

        current:null,
        formVisible: false,
        title: '添加子权限',
        form:{
          id: '',
          parent_id: '',
          name: '',
          show_name: ''
        }
      }
    },
    methods: {
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
        this.formVisible = true;
        this.title = '编辑权限';
      },
      reset(){
        this.current = null;
        Object.assign(this.form, {
          id: '',
          parent_id: '',
          name: '',
          show_name: ''
        })
      },
      add(data) {
        this.reset()
        this.current = data;
        this.formVisible = true;
      },
      doSubmit(){
        if(!this.form.id){
          this.doAdd()
        }else{
          this.doEdit()
        }
      },
      async doAdd(){
        const newChild = {show_name: this.form.show_name, disabled: true, name: this.form.name,  children: [] };
        if (!this.current.children) {
          this.$set(this.current, 'children', []);
        }
        this.formVisible = false
        let res = await api.addPermission({parent_id: this.current.id, name: this.form.name, show_name: this.form.show_name})
        newChild.id = res.data.id;
        this.current.children.push(newChild);
        if(res.success){
          this.$message({
            type: 'success',
            message: '添加成功!'
          });
          this.reset()
        }else{
          this.formVisible = true
        }
      },
      async doEdit(){
        let res = await api.editPermission({id: this.form.id, name: this.form.name, show_name: this.form.show_name})
        this.$message({
          type: 'success',
          message: '修改成功!'
        });
        this.current.name = this.form.name
        this.current.show_name = this.form.show_name
        this.reset()
        this.formVisible = false
      },
      remove(node, data) {
        this.$confirm('删除权限存在风险,是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deletePermission({id: data.id})
          const parent = node.parent;
          const children = parent.data.children || parent.data;
          const index = children.findIndex(d => d.id === data.id);
          children.splice(index, 1);
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        });
      },
      handleCheckChange(data, checked, indeterminate) {
        console.log(data,`.............`, checked, `.............`, indeterminate);
        return true;
      },
      async loadPermissionsTree(){
        let res = await api.getPermissionsTree({disabled: true})
        this.treeData = [res.data[Object.keys(res.data)[0]]];
      }
    },
    async mounted() {
      await this.loadPermissionsTree()
    }
  }
</script>
<style scoped>
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

<template>
  <div>
    <div v-title="'权限管理'"></div>
    <div>
      <div class="l-block">
        <div class="l-block-header">所有权限</div>
        <div class="l-block-body">
          <!--default-expand-all-->
          <el-table
                  :data="tableData"
                  style="width: 100%;margin-bottom: 20px;"
                  row-key="id"
                  border
                  :tree-props="{children: 'children', hasChildren: 'hasChildren'}">
            <el-table-column
                    prop="show_name"
                    label="权限"
                    width="240">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="权限字符串">
            </el-table-column>
            <el-table-column
                    label="操作">
              <template slot-scope="scope">
            <span>
              <el-button class="l-lighter"
                      type="text"
                      @click="() => edit(scope.row)">
                编辑
              </el-button>
              <el-button class="l-lighter"
                      type="text"
                      @click="() => add(scope.row)">
                新增
              </el-button>
              <el-button class="l-lighter"
                      type="text"
                      @click="() => remove(scope.row)">
                删除
              </el-button>
            </span>
              </template>
            </el-table-column>
          </el-table>
        </div>
      </div>
    </div>
    <el-dialog :title="title" :visible.sync="formVisible"  :close-on-click-modal="false">
      <el-form :model="form" label-width="100px">
        <el-form-item label="权限">
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
  import api from 'sysApi'
  export default {
    name: 'privilegesPermissions',
    data() {
      return {
        tableData: [],
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
      remove(row) {
        this.$confirm('删除权限存在风险,是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deletePermission({id: row.id})
          await this.loadPermissionsTree()
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
        this.tableData = this.treeData
      }
    },
    async mounted() {
      await this.loadPermissionsTree()
    }
  }
</script>
<style lang="less" scoped>
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    padding-right: 8px;
    .el-button--mini{
      font-size: 14px;
    }
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
</style>

<template>
  <div>
    <div v-title="'字段类型'"></div>
    <div class="l-top-menu">
      <div>
        <el-button type="primary" @click="add" size="small">新增</el-button>
      </div>
      <div></div>
    </div>
    <el-table
      v-loading="loading"
      :data="tableData"
      style="width: 100%">
      <el-table-column
        prop="id"
        label="ID"
        width="100">
      </el-table-column>
      <el-table-column
        prop="type"
        label="字段">
      </el-table-column>
      <el-table-column
        prop="name"
        label="名称">
      </el-table-column>
      <el-table-column
        label="操作">
        <template slot-scope="scope">
          <el-button type="text" class="l-lighter" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" class="l-lighter" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-dialog title="添加类型" :visible.sync="formVisible" :close-on-click-modal="false">
      <el-form :model="form">
        <el-form-item label="名称" :label-width="w">
          <el-input v-model="form.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="字段" :label-width="w">
          <el-input v-model="form.type" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="带选项" :label-width="w">
          <el-radio v-model="form.extra.options" :label="false">否</el-radio>
          <el-radio v-model="form.extra.options" :label="true">是</el-radio>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="formVisible = false">取 消</el-button>
        <el-button type="primary" @click="submit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import api from 'sysApi'
  export default {
      name: 'cmsSettingFieldTypes',
    data(){
      return {
        w: '80px',
        loading: true,
        tableData: [],
        formVisible: false,
        form: {
          id: '',
          type: '',
          name: '',
          extra: {
            options: false
          }
        },
      }
    },
    methods:{
      handleEdit(row){
        this.formVisible = true;
        Object.assign(this.form, row);
      },
      handleDelete(row){
        alert(JSON.stringify(row));
      },
      add(){
        this.formVisible = true;
        Object.assign(this.form, {
          name: '',
          type: ''
        })
      },
      async submit(){
        let res = await api.saveModelFieldType(this.form)
        if(res.success) {
          this.loading = true;
          this.loadTypes();
          this.formVisible = false;
          let successMsg = '添加成功!';
          if(this.form.id){
            successMsg = '编辑成功!';
          }
          this.$message.success(successMsg);
        }else{
          this.$message.warning(res.error);
        }
      },
      async loadTypes(){
        let res = await api.getModelFieldTypes()
        this.loading = false;
        this.tableData = res.data;
      }
    },
    async created() {
      await this.loadTypes();
    }
  }
</script>
<style lang="less" scoped>
  .l-top-menu {
    display: flex;
    flex-flow: row nowrap;
    justify-content: space-between;
  }
</style>

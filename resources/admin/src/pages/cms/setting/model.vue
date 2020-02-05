<template>
  <div>
    <div class="l-top-menu">
      <div>
<!--        <el-button type="primary" @click="add">新增</el-button>-->
        <router-link to="/cms/setting/model/add"><el-button type="primary" size="small">新增</el-button></router-link>
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
        width="180">
      </el-table-column>

      <el-table-column
        prop="name"
        label="名称">
      </el-table-column>

      <el-table-column
        prop="channel_template_prefix"
        label="栏目模板前缀">
      </el-table-column>

      <el-table-column
      prop="content_template_prefix"
      label="内容模板前缀">
      </el-table-column>

      <el-table-column
      label="操作">
        <template slot-scope="scope">
          <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
        </template>
      </el-table-column>

    </el-table>
    <el-dialog title="添加类型" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="类型" label-width="100px">
          <el-input v-model="form.type" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="名称" label-width="100px">
          <el-input v-model="form.name" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="submit">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        loading: true,
        tableData: [],
        dialogFormVisible: false,
        form: {
          name: '',
          type: ''
        },
      }
    },
    methods:{
      handleEdit(row){
        this.$router.push('/cms/setting/model/edit/'+row.id);
      },
      add(){
        this.$router.push('/cms/setting/model/add');
      },
      submit(){
        this.$http
          .post("/admin/cms/model/field/type/add", this.form)
          .then(res => {
            // alert(JSON.stringify(res))
            if(res.success) {
              this.loading = true;
              this.loadTypes();
              this.dialogFormVisible = false;
              this.$message({
                message: '添加成功!',
                type: 'success'
              });
            }else{
              this.$message({
                message: res.error,
                type: 'warning'
              });
            }
          });
      },
      loadTypes(){
        this.$http
          .get("/admin/cms/model")
          .then(res => {
            this.loading = false;
            this.tableData = res.data;
          });
      }
    },
    created() {
      this.loadTypes();
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

<style scoped>
  .l-block-body >>> .el-table .cell{
    text-align: center;
  }
</style>
<template>
  <div>
    <div v-title="'模型管理'"></div>
    <div class="l-block">
    <div class="l-block-header">
      <div>
        <!--<router-link to="/cms/setting/model/add">-->
          <el-button @click="handleAdd" type="primary" size="small">新增</el-button>
        <!--</router-link>-->
      </div>
      <div></div>
    </div>
    <div class="l-block-body">
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
        prop="name"
        label="名称">
      </el-table-column>
      <el-table-column
        prop="channel_template_prefix"
        label="栏目模板前缀"
      >
      </el-table-column>
      <el-table-column
        label="内容模板前缀">
        <template slot-scope="scope">
          <div v-if="scope.row.has_contents">{{scope.row.content_template_prefix}}</div>
        </template>
      </el-table-column>
      <el-table-column
        label="栏目字段"
        width="100"
      >
        <template slot-scope="scope">
          <el-button type="text" @click="handleFieldManager(scope.row, 'channel')">管理</el-button>
        </template>
      </el-table-column>
      <el-table-column
        label="内容字段"
        width="100"
      >
        <template slot-scope="scope">
          <el-button v-if="scope.row.has_contents" type="text" @click="handleFieldManager(scope.row, 'content')">管理</el-button>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
      >
        <template slot-scope="scope">
          <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button type="text" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
  </el-table>
    </div>
    </div>
    <el-dialog title="添加模型" :visible.sync="dialogFormVisible">
      <el-form :model="modelForm">
        <el-form-item label="模型名" label-width="100px">
          <el-input v-model="modelForm.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="是否有内容" label-width="100px">
          <el-radio-group v-model="modelForm.has_contents">
            <el-radio :label="1">是</el-radio>
            <el-radio :label="0">否(单页)</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="栏目模板前缀" label-width="100px">
          <el-input v-model="modelForm.channel_template_prefix" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="内容模板前缀" label-width="100px" v-if="modelForm.has_contents">
          <el-input v-model="modelForm.content_template_prefix" autocomplete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="save">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import api from '../../../api/index'
  export default {
    data(){
      return {
        loading: true,
        tableData: [],
        dialogFormVisible: false,
          modelForm: {
            id: null,
            name: '',
            has_contents: 1,
            channel_template_prefix: '',
            content_template_prefix: ''
        },
      }
    },
    methods:{
      handleAdd(){
          this.dialogFormVisible = true;
          Object.assign(this.modelForm, {
              id: null,
              name: '',
              has_contents: 1,
              channel_template_prefix: '',
              content_template_prefix: ''
          })
      },
      handleFieldManager(row, type=''){
          this.$router.push('/cms/setting/model/edit?type='+type+'&model_id='+row.id);
      },
      handleEdit(row){
          this.dialogFormVisible = true;
          this.loadModel(row.id)
      },
      handleDelete(row){
        this.$confirm('确定删除模型?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deleteModel({id: row.id})
          if(res.success){
            await this.loadModels()
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

        });
      },
//      add(){
//        this.dialogFormVisible = true;
//        //this.$router.push('/cms/setting/model/add');
//      },
//      async submit(){
//        let res = await api.addFieldType(this.form)
//        if(res.success){
//          this.loading = true;
//          await this.loadModels();
//          this.dialogFormVisible = false;
//          this.$message({
//            message: '添加成功!',
//            type: 'success'
//          });
//        }else{
//          this.$message({
//            message: res.error,
//            type: 'warning'
//          });
//        }
//      },
        async save(){
            let res = await api.saveModel(this.modelForm)
            if(res.success){
                let message = '添加成功!'
                if(this.modelForm.id){
                    message = '更新成功!';
                }
                this.$message({
                    message: message,
                    type: 'success'
                });
                Object.assign(this.modelForm, res.data);
                this.id = res.data.id;
//                await this.loadModel(this.id);
                await this.loadModels()
                this.dialogFormVisible = false;
            }else{
                let message = '出错了!请联系管理员';
                this.$message({
                    message: message,
                    type: 'warning'
                });
            }
        },
      async loadModels(){
        let res = await api.getModels()
        this.loading = false;
        this.tableData = res.data;
      },
      async loadModel(id){
          let res = await api.getModel({id})
          let model = res.data
          this.modelForm = Object.assign({}, {
              id: model.id,
              name: model.name,
              has_contents: model.has_contents,
              channel_template_prefix: model.channel_template_prefix,
              content_template_prefix: model.content_template_prefix
          });
      },
    },
    async created() {
      await this.loadModels();
    }
  }
</script>

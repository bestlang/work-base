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
        prop="template_prefix"
        label="模板前缀"
      >
      </el-table-column>
      <el-table-column
        label="栏目字段"
        width="100"
      >
        <template slot-scope="scope">
          <el-button size="mini" type="primary" @click="handleFieldManager(scope.row, 'channel')">管理</el-button>
        </template>
      </el-table-column>
      <el-table-column
        label="内容字段"
        width="100"
      >
        <template slot-scope="scope">
          <el-button size="mini" v-if="scope.row.has_contents" type="primary" @click="handleFieldManager(scope.row, 'content')">管理</el-button>
        </template>
      </el-table-column>
      <el-table-column
        label="操作"
      >
        <template slot-scope="scope">
          <el-button size="mini" type="primary" @click="handleEdit(scope.row)">编辑</el-button>
          <el-button size="mini" type="danger" @click="handleDelete(scope.row)">删除</el-button>
        </template>
      </el-table-column>
  </el-table>
    </div>
    </div>
    <el-dialog title="添加模型" :visible.sync="dialogFormVisible">
      <el-form :model="modelForm" size="small">
        <el-form-item label="模型名" label-width="100px">
          <el-input v-model="modelForm.name" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="是否有内容" label-width="100px">
          <el-radio-group v-model="modelForm.has_contents">
            <el-radio :label="1">是</el-radio>
            <el-radio :label="0">否(单页)</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="模板前缀" label-width="100px">
          <el-select v-model="modelForm.template_prefix" placeholder="请选择">
            <el-option
                    v-for="(item, index) in optionalTemplatePaths"
                    :key="index"
                    :label="item"
                    :value="item">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false" size="small">取 消</el-button>
        <el-button type="primary" @click="save" size="small">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import api from 'sysApi'
  export default {
      name: 'cmsSettingModel',
    data(){
      return {
        loading: true,
        tableData: [],
        dialogFormVisible: false,
        optionalTemplatePaths: [],
          modelForm: {
            id: null,
            name: '',
            has_contents: 1,
            template_prefix: '',
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
              template_prefix: '',
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
            this.$message.success('删除成功!');
          }else{
            this.$message.error(res.error);
          }

        });
      },
        async save(){
            let res = await api.saveModel(this.modelForm)
            if(res.success){
                let message = '添加成功!'
                if(this.modelForm.id){
                    message = '更新成功!';
                }
                this.$message.success('success');
                Object.assign(this.modelForm, res.data);
                this.id = res.data.id;
//                await this.loadModel(this.id);
                await this.loadModels()
                this.dialogFormVisible = false;
            }else{
                let message = '出错了!请联系管理员';
                this.$message.warning(message);
            }
        },
      async loadModels(){
        let res = await api.getModels()
        this.loading = false;
        this.tableData = res.data;
      },
      async loadTemplatePrefix(){
          let {data} = await api.getOptionalTemplatePrefix();
          this.loading = false;
          this.optionalTemplatePaths = data;
          console.log(`optionalTemplatePaths:`, JSON.stringify(this.optionalTemplatePaths))
      },
      async loadModel(id){
          let res = await api.getModel({id})
          let model = res.data
          this.modelForm = Object.assign({}, {
              id: model.id,
              name: model.name,
              has_contents: model.has_contents,
              template_prefix: model.template_prefix
          });
      },
    },
    async created() {
      await this.loadModels();
      await this.loadTemplatePrefix();
    }
  }
</script>

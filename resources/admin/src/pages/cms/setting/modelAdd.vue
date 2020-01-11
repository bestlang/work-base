<template>
  <div>
    <div class="top-buttons" style="display: flex;flex-flow: row nowrap;">
      <router-link to="/cms/setting/model" tag="div"><span class="iconfont">&#xe601;</span>返回</router-link>
      <el-divider direction="vertical"></el-divider>
      <div>新增模型</div>
    </div>
    <div>
      <el-tabs v-model="activeName"  type="card" @tab-click="handleClick">
        <el-tab-pane label="基本信息" name="first">
          <div style="margin-top: 20px">
            <el-form ref="form" :model="form" label-width="120px">
              <el-form-item label="模型名">
                <el-input v-model="form.name"></el-input>
              </el-form-item>
              <el-form-item label="栏目模板前缀">
                <el-input v-model="form.channel_template_prefix"></el-input>
              </el-form-item>
              <el-form-item label="内容模板前缀">
                <el-input v-model="form.content_template_prefix"></el-input>
              </el-form-item>
              <el-form-item>
                <el-button type="primary" @click="save">保存</el-button>
              </el-form-item>
            </el-form>
          </div>
        </el-tab-pane>
        <el-tab-pane label="栏目字段" name="second">
          <div style="text-align: right;margin-bottom: 20px;">
            <el-button type="primary">添加</el-button>
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
              label="字段名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="字段类型">
            </el-table-column>
            <el-table-column
              label="操作">
              <template slot-scope="scope">
                <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
              </template>
            </el-table-column>
          </el-table>
        </el-tab-pane>
        <el-tab-pane label="内容字段" name="third">
          <div style="text-align: right;margin-bottom: 20px;">
            <el-button type="primary">添加</el-button>
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
              label="字段名">
            </el-table-column>
            <el-table-column
              prop="type"
              label="字段类型">
            </el-table-column>
            <el-table-column
              label="操作">
              <template slot-scope="scope">
                <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
              </template>
            </el-table-column>
          </el-table>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        loading: false,
        activeName: 'first',
        tableData:[],
        form:{
          id: null,
          name: '',
          channel_template_prefix: '',
          content_template_prefix: ''
        }
      }
    },
    computed:{
      channelFields(){
        this.tableData.filter(function(item){
          return item.is_channel === 1;
        })
      },
      contentFields(){
        this.tableData.filter(function(item){
          return item.is_channel === 0;
        })
      }
    },
    methods:{
      loadModel(id){
        this.$http
          .get("/admin/cms/model/get", {params: {id}})
          .then(res => {
            Object.assign(this.form, res.data)
          });
      },
      save(){
        this.$http
          .post("/admin/cms/model/add", this.form)
          .then(res => {
            if(res.success){
              this.$message({
                message: '添加成功!',
                type: 'success'
              });
              Object.assign(this.form, res.data);
            }else{
              this.$message({
                message: '出错了!请联系管理员',
                type: 'warning'
              });
            }
          });
      },
      handleClick(tab, event) {
        console.log(tab, event);
      },
    },
    mounted() {
      let id = this.$route.params.id;
      if(id){
        this.loadModel(id);
      }
    }
  }
</script>
<style lang="less" scoped>

</style>

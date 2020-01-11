<template>
  <div>
    <div class="top-buttons" style="display: flex;flex-flow: row nowrap; justify-content: space-between;">
      <div>新增模型</div>
      <router-link to="/cms/setting/model"><el-button><span class="iconfont">&#xe617;</span></el-button></router-link>
    </div>
    <div>
      <div class="l-form-block">
        <el-divider content-position="left">模型信息</el-divider>
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
        </el-form>
      </div>
      <div class="l-form-block">
        <el-divider content-position="left">模型字段</el-divider>
        <div class="l-flex-row">
          <el-button type="primary">新增</el-button>
        </div>
        <el-divider></el-divider>
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
            prop="is_channel"
            label="分类">
          </el-table-column>

        </el-table>
      </div>
<!--      <div class="l-form-block">-->
<!--        模型基本字段-->
<!--        <el-divider></el-divider>-->
<!--        <el-form ref="form" :model="form" label-width="120px">-->
<!--          <el-form-item label="模型名">-->
<!--            <el-input v-model="form.name"></el-input>-->
<!--          </el-form-item>-->
<!--          <el-form-item label="栏目模板前缀">-->
<!--            <el-input v-model="form.channel_template_prefix"></el-input>-->
<!--          </el-form-item>-->
<!--          <el-form-item label="内容模板前缀">-->
<!--            <el-input v-model="form.content_template_prefix"></el-input>-->
<!--          </el-form-item>-->
<!--        </el-form>-->
<!--      </div>-->
<!--      <div class="l-form-block">-->
<!--        模型栏目字段-->
<!--        <el-divider></el-divider>-->
<!--        <el-form ref="form" :model="form" label-width="120px">-->
<!--          <el-form-item label="标题">-->
<!--            <el-input v-model="form.title"></el-input>-->
<!--          </el-form-item>-->
<!--          <el-form-item label="关键字">-->
<!--            <el-input v-model="form.keywords"></el-input>-->
<!--          </el-form-item>-->
<!--          <el-form-item label="描述">-->
<!--            <el-input v-model="form.description"></el-input>-->
<!--          </el-form-item>-->
<!--        </el-form>-->
<!--      </div>-->
    </div>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        loading: false,
        tableData:[],
        form:{
          name: '',
          channel_template_prefix: '',
          content_template_prefix: ''
        }
      }
    }
  }
</script>
<style lang="less" scoped>
  .l-form-block{
    padding: 20px;
    /*border: 1px solid #ebebeb;*/
    margin-bottom: 20px;
  }
</style>

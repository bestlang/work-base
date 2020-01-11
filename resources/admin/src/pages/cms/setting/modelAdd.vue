<template>
  <div>
    <div class="top-buttons" style="display: flex;flex-flow: row nowrap;">
      <router-link to="/cms/setting/model" tag="div"><span class="iconfont">&#xe601;</span>返回</router-link>
      <el-divider direction="vertical"></el-divider>
      <div>新增模型</div>
    </div>
    <div>
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="用户管理" name="first">
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
        </el-tab-pane>
        <el-tab-pane label="配置管理" name="second">
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
        </el-tab-pane>
        <el-tab-pane label="角色管理" name="third">
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
        activeName: 'second',
        tableData:[],
        form:{
          name: '',
          channel_template_prefix: '',
          content_template_prefix: ''
        }
      }
    },
    methods:{
      handleClick(tab, event) {
        console.log(tab, event);
      }
    }
  }
</script>
<style lang="less" scoped>
  .l-form-block{
    padding: 0 20px;
    /*border: 1px solid #ebebeb;*/
    margin-bottom: 20px;
  }
</style>

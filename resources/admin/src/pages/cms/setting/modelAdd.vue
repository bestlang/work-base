<template>
  <div class="l-model-add">
    <div class="top-buttons" style="display: flex;flex-flow: row nowrap;">
      <router-link to="/cms/setting/model" tag="div"><span class="iconfont">&#xe601;</span>返回</router-link>
      <el-divider direction="vertical"></el-divider>
      <div>{{form.id ? '编辑':'新增'}}模型</div>
    </div>
    <div>
      <el-tabs tab-position="left" v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="基本信息" name="basic">
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
        </el-tab-pane>
        <el-tab-pane label="栏目字段" name="channel">
          <div style="text-align: left;margin-bottom: 20px;">
            <el-button type="primary" @click="add('channel')">添加</el-button>
          </div>
          <el-table
            border
            v-loading="loading"
            :data="channelFields"
            style="width: 100%">
            <el-table-column
              prop="id"
              label="ID"
              width="180">
            </el-table-column>
            <el-table-column
              prop="field"
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
        <el-tab-pane label="内容字段" name="content">
          <div style="text-align: left;margin-bottom: 20px;">
            <el-button type="primary" @click="add('content')">添加</el-button>
          </div>
          <el-table
            border
            v-loading="loading"
            :data="contentFields"
            style="width: 100%">
            <el-table-column
              prop="id"
              label="ID"
              width="180">
            </el-table-column>
            <el-table-column
              prop="field"
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
    <el-dialog :title="fieldTitle" :visible.sync="fieldVisible">
      <el-form :model="fieldForm" label-width="100px">
        <el-form-item label="栏目字段">
          <el-input v-model="fieldForm.is_channel" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="字段">
          <el-input v-model="fieldForm.field" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="标签">
          <el-input v-model="fieldForm.label" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="类型">
          <el-select v-model="fieldForm.type" placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary">取消</el-button>
        <el-button type="primary" @click="doSaveField">确定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  export default {
    data(){
      return {
        id:null,
        loading: false,
        activeName: 'basic',
        fields:[],
        form:{
          id: null,
          name: '',
          channel_template_prefix: '',
          content_template_prefix: ''
        },
        fieldTitle:'添加字段',
        fieldVisible: false,
        fieldForm:{
          id: '',
          model_id: null,
          type: '',// text, select ...
          field: '',
          label: '',
          extra: '',
          is_channel: 0, // 1-channel | 0-content
          is_custom: 1,
          is_display: 1,
          is_required: 0,
        },
        options:[
          {
            value: 'text',
            label: '文本框'
          },
          {
            value: 'select',
            label: '单选'
          },
          {
            value: 'checkbox',
            label: '多选'
          }
        ]
      }
    },
    computed:{
      channelFields(){
        return this.fields.filter(function(item){
          return item.is_channel === 1;
        })
      },
      contentFields(){
        return this.fields.filter(function(item){
          return item.is_channel === 0;
        })
      }
    },
    methods:{
      beforeLeave(activeName, oldActiveName){
        return true;
      },
      add(type){
        if(!this.form.id){
          this.$message({
            message: '请先提交基本信息!',
            type: 'warning'
          });
          this.activeName = 'basic';
          return;
        }
        if(type == 'channel'){
          this.fieldForm.is_channel = 1;
        }else if(type == 'content'){
          this.fieldForm.is_channel = 0;
        }
        this.fieldVisible = true;
      },
      loadModel(id){
        this.$http
          .get("/admin/cms/model/get", {params: {id}})
          .then(res => {
            this.fields = res.data.fields;
            console.log(`.............this.fields:`, this.fields)
            Object.assign(this.form, res.data)
            this.fieldForm.model_id = res.data.id;
          });
      },
      save(){
        this.$http
          .post("/admin/cms/model/save", this.form)
          .then(res => {
            if(res.success){
              let message = '添加成功!'
              if(this.form.id){
                message = '更新成功!';
              }
              this.$message({
                message: message,
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
      doSaveField(){
        this.$http
          .post("/admin/cms/model/save/field", this.fieldForm)
          .then(res => {
            if(res.success){
              this.fieldVisible = false;
              let message = '添加成功!'
              if(this.fieldForm.id)
                message = '更新成功!';
              this.$message({
                message: message,
                type: 'success'
              });
              this.loadModel(this.id);
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
      this.id = id;
      if(id){
        this.loadModel(id);
      }
    }
  }
</script>

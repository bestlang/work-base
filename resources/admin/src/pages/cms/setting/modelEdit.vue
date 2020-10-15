<style scoped>
  .l-block-body >>> .el-table .cell{
    text-align: center;
  }
</style>
<template>
  <div class="l-block">
    <div class="l-block-header">
      <div>
        <router-link to="/cms/setting/model" tag="span"><span class="iconfont">&#xe601;</span>返回</router-link>
        <el-divider direction="vertical"></el-divider>
        <span v-if="currentModel"><span style="font-weight: 700">“{{currentModel.name}}”</span>{{type=='content'?'内容':'栏目'}}字段管理</span>
      </div>
    </div>
    <div class="l-block-body">
          <div class="l-block" v-if="type=='channel'">
            <div class="l-block-header">
              <el-button type="primary" @click="add(type)">添加</el-button>
            </div>
            <div class="l-block-body">
              <el-table
              border
              v-loading="loading"
              :data="channelFields">
              <el-table-column
                prop="id"
                label="ID">
              </el-table-column>
              <el-table-column
                prop="field"
                label="字段">
              </el-table-column>
              <el-table-column
                prop="label"
                label="标签">
              </el-table-column>
              <el-table-column
                label="排序值(升序)">
                <template slot-scope="scope">
                  <el-input v-model="scope.row.order_factor" class="l-w-60"></el-input>
                </template>
              </el-table-column>
              <el-table-column
                prop="type"
                label="字段类型">
              </el-table-column>
              <el-table-column
                label="操作">
                <template slot-scope="scope">
                  <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
                  <el-button type="text" @click="handleDelete(scope.row)">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
            </div>
            <div class="l-block-bottom">
              <el-button @click="saveOrderFactor">保存排序</el-button>
            </div>
          </div>
          <div class="l-block" v-if="type=='content'">
            <div class="l-block-header">
              <el-button type="primary" @click="add(type)">添加</el-button>
            </div>
            <div class="l-block-body">
              <el-table
                border
                v-loading="loading"
                :data="contentFields">
                <el-table-column
                  prop="id"
                  label="ID">
                </el-table-column>
                <el-table-column
                  prop="field"
                  label="字段">
                </el-table-column>
                <el-table-column
                  prop="label"
                  label="标签">
                </el-table-column>
                <el-table-column
                  label="排序值(升序)">
                  <template slot-scope="scope">
                    <el-input v-model="scope.row.order_factor" class="l-w-60"></el-input>
                  </template>
                </el-table-column>
                <el-table-column
                  prop="type"
                  label="字段类型">
                </el-table-column>
                <el-table-column
                  label="操作">
                  <template slot-scope="scope">
                    <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
                    <el-button type="text" @click="handleDelete(scope.row)">删除</el-button>
                  </template>
                </el-table-column>
              </el-table>
            </div>
            <div class="l-block-bottom">
              <el-button @click="saveOrderFactor">保存排序</el-button>
            </div>
          </div>
    </div>
    <el-dialog :title="fieldTitle" :visible.sync="fieldVisible" :close-on-click-modal="false">
      <el-form :model="fieldForm" label-width="100px">
        <el-form-item label="标签">
          <el-input v-model="fieldForm.label" autocomplete="off"></el-input>
        </el-form-item>
        <el-form-item label="字段">
          <el-input v-model="fieldForm.field" autocomplete="off"></el-input>
        </el-form-item>

        <el-form-item label="类型">
          <el-select v-model="fieldForm.type" placeholder="请选择">
            <el-option
              v-for="option in options"
              :key="option.value"
              :label="option.name"
              :value="option.type">
            </el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="选项" v-if="showOptions">
            <add-options :options="fieldForm.extra" @optionsChange="handleOptionsChange"></add-options>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="fieldVisible = false">取消</el-button>
        <el-button type="primary" @click="doSaveField">确定</el-button>
      </div>
    </el-dialog>
  </div>
</template>
<script>
  import addOptions from "../components/addOptions";
  import api from 'sysApi'
  import {mapGetters} from 'vuex'
  export default {
      name: 'cmsSettingModelEdit',
    components:{
      'add-options': addOptions
    },
    data(){
      return {
        model_id:null,
        type: '',//channel, content
        loading: false,
        activeName: 'basic',
        fields:[],
        fieldTitle:'添加字段',
        fieldVisible: false,
        fieldForm:{
          id: '',
          model_id: null,
          type: '',
          field: '',
          label: '',
          extra: [],
          is_channel: 0,
          is_custom: 1,
          is_display: 1,
          is_required: 0,
        },
        showOptions: false,
        options:[]
      }
    },
    watch:{
      ['fieldForm.type'](newValue, oldValue){
        this.options.forEach((item) => {
          if(item.type == newValue){
            if(item.extra.options){
              this.showOptions = true;
            }else{
              this.showOptions = false;
            }
          }
        });
      }
    },
    computed:{
      ...mapGetters(['currentModel']),
      channelFields(){
        return this.fields.filter(function(item){
          return item.is_channel === 1;
        })
      },
      contentFields(){
        return this.fields.filter(function(item){
          return item.is_channel === 0;
        })
      },
    },
    methods:{
      async saveOrderFactor(isChannel = 0){
        let ids = [];
        let orders = [];
        let fields = [];
        if(isChannel){
          fields = this.channelFields;
        }else{
          fields = this.contentFields;
        }
        this.fields.forEach( item => {
          ids.push(item.id)
          orders.push(item.order_factor)
        });
        if(!ids.length){
          this.$message({
            type: 'warning',
            message: '无内容!'
          });
          return false;
        }
        let res = await api.saveModelFieldOrder({ids, orders})

        this.$message({
          type: 'success',
          message: '保存成功!'
        });
      },
      handleEdit(row){
        this.fieldVisible = true
        Object.assign(this.fieldForm, row);
      },
      handleDelete(row){
        this.$confirm('确定删除字段?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let model_id = this.fieldForm.model_id
          let res = await api.deleteModelField({model_id: model_id, id: row.id})
          await this.loadModel(model_id);
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
        });
      },

      add(type){
        if(type == 'channel'){
          this.fieldForm.is_channel = 1;
        }else if(type == 'content'){
          this.fieldForm.is_channel = 0;
        }
        this.fieldVisible = true;
        Object.assign(this.fieldForm, {
          id: '',
          type: '', // text, select ...
          field: '',
          label: '',
          extra: [{name: '', value: ''}],
          is_custom: 1,
          is_display: 1,
          is_required: 0,
        });
        this.showOptions = false;
      },
      async loadFieldTypes(){
        let res = await api.getModelFieldTypes()
        this.options = res.data;
      },
      async loadModel(id){
        let res = await api.getModel({id})
        this.$store.dispatch(this.$types.CMS_CURRENT_MODEL, res.data);
        this.fields = res.data.fields;
        console.log(`this.fields:`,this.fields)
        this.fieldForm.model_id = res.data.id;
      },
      async doSaveField(){
        let res = await api.modelSaveField(this.fieldForm)
        if(res.success){
          this.fieldVisible = false;
          let message = '添加成功!'
          if(this.fieldForm.id)
            message = '更新成功!';
          this.$message({
            message: message,
            type: 'success'
          });
          await this.loadModel(this.model_id);
        }else{
          this.$message({
            message: '出错了!请联系管理员',
            type: 'warning'
          });
        }
      },
      handleClick(tab, event){
        console.log(tab, event);
      },
      handleOptionsChange(val){
        this.fieldForm.extra = val;
      }
    },
    async mounted(){
      let model_id = parseInt(this.$route.query.model_id || 0);
      this.model_id = model_id;
      if(this.model_id){
          await this.loadModel(this.model_id);
      }
      let type = this.$route.query.type.toString();
      this.type = type;

      await this.loadFieldTypes();
    }
  }
</script>

<style lang="less" scoped>
  .l-channel-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 50px - 20px);
    margin:-20px 0 -20px -20px;
    overflow-x: hidden;
    .l-tree-container{
      min-width: 200px;
      padding: 20px;
      border-right: 1px solid #f4f4f4;
      flex-shrink: 0;
    }
    .l-tree-content{
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-flow: row nowrap;
      box-sizing: border-box;
      width: calc(100% - 240px);
    }
  }
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    font-weight: lighter;
    /*padding-right: 8px;*/
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
  .l-channel-form{width: 100%;}
  .l-channel-info ul li{
    line-height: 40px;
  }
</style>
<template>
  <div class="l-channel-list">
      <div v-title="'栏目管理'"></div>
      <div class="l-tree-container">
        <el-tree
          @node-click="handleNodeClick"
          icon-class="el-icon-caret-right"
          :default-expand-all="true"
          ref="tree"
          :data="channels"
          node-key="id"
          :props="customProps"
          :expand-on-click-node="false">
          <span class="custom-tree-node" slot-scope="{ node, data }">
            <span><span v-if="!data.children.length" class="iconfont">&#xe92a;</span>{{ node.label }}</span>
          </span>
        </el-tree>
      </div>
      <div class="l-tree-content" v-if="showChildren">
        <div class="l-block">
            <div class="l-block-header" v-if="parentChannel && parentChannel.id">
                <span><i class="iconfont">&#xe64c;</i> {{parentChannel.name ? parentChannel.name : ''}}</span>
                <el-button-group>
                  <el-button style="padding: 3px 10px" type="text" @click="editChannel(parentChannel)">编辑</el-button>
                  <el-button style="padding: 3px 10px" type="text" @click="addChannel(parentChannel)">新增栏目</el-button>
                </el-button-group>
            </div>
            <div class="l-block-header" v-if="!channels.length">
              <el-button style="padding: 3px 10px" type="text" @click="addChannel({id: 0})">新增栏目</el-button>
            </div>
            <div class="l-block-body">
              <el-table
                v-loading="loading"
                :data="channelChildren"
                style="width: 100%">
                <el-table-column
                  prop="id"
                  label="ID"
                  width="80">
                </el-table-column>
                <el-table-column
                  prop="name"
                  label="栏目名">
                </el-table-column>
                <el-table-column
                  label="操作">
                  <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="editChannel(scope.row)">编辑</el-button>
                    <el-button type="success" size="mini" @click="addChannel(scope.row)">新增子栏目</el-button>
                    <el-button type="danger" size="mini" @click="deleteChannel(scope.row)">删除</el-button>
                  </template>
                </el-table-column>
              </el-table>
            </div>
        </div>
      </div>
      <div class="l-tree-content" v-if="!showChildren">
        <div class="l-block" v-if="!showChildren">
          <div class="l-block-header" v-if="parentChannel && parentChannel.id">
              <span>
                <span v-if="channelForm.id"><i class="iconfont">&#xe64c;</i> {{channelForm.name}}</span>
                </span>
              <el-button-group>
                <el-button style="padding: 3px 10px" type="text" @click="addChannel(channelForm)">新增栏目</el-button>
                <el-button style="padding: 3px 10px" type="text" @click="deleteChannel(channelForm)">删除</el-button>
              </el-button-group>
          </div>
          <div class="l-block-body">
            <el-form :model="channelForm" label-width="100px">
                <el-form-item label="上级栏目">
                    <tree-select v-model="channelForm.parent_id" :multiple="false" :options="channelsTree"  :default-expand-level="10" :normalizer="normalizer" />
                </el-form-item>
              <el-form-item label="模型">
                <el-select v-model="channelForm.model_id" placeholder="请选择">
                  <el-option
                    v-for="m in models"
                    :key="m.name"
                    :label="m.name"
                    :value="m.id">
                  </el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="栏目名">
                <el-input v-model="channelForm.name" autocomplete="off"></el-input>
              </el-form-item>
            <el-form-item label="栏目模板">
                <el-select v-model="channelForm.template" placeholder="请选择">
                    <el-option
                            v-for="(item, index) in optionalTemplatePath"
                            :key="index"
                            :label="item"
                            :value="item">
                    </el-option>
                </el-select>
            </el-form-item>
                <el-form-item label="内容模板">
                    <el-select v-model="channelForm.content_template" placeholder="请选择">
                        <el-option
                                v-for="(item, index) in optionalTemplatePath"
                                :key="index"
                                :label="item"
                                :value="item">
                        </el-option>
                    </el-select>
                </el-form-item>
              <template v-for="(item, index) in customChannelFields">
                <el-form-item v-if="item.type=='text'" :label="item.label">
                  <el-input :key="index" :name="item.field" v-model="channelForm[item.field]"></el-input>
                </el-form-item>
                <el-form-item v-if="item.type=='checkbox' && Array.isArray(channelForm[item.field])" :label="item.label">
                  <el-checkbox-group v-model="channelForm[item.field]">
                      <el-checkbox :label="option.value" v-for="option in item.extra">{{option.name}}</el-checkbox>
                  </el-checkbox-group>
                </el-form-item>
                <el-form-item v-if="item.type=='textarea'" :label="item.label">
                  <el-input type="textarea" v-model="channelForm[item.field]"></el-input>
                </el-form-item>
                <el-form-item v-if="item.type=='content'" class="l-mb-22" :label="item.label">
                  <div>
                    <vue-ueditor-wrap v-model="channelForm[item.field]" :config="uConfig"></vue-ueditor-wrap>
                  </div>
                </el-form-item>
              </template>
                <el-form-item label="栏目推荐位" v-if="channelPositions.length">
                    <el-checkbox-group v-model="channelForm['positions']">
                        <el-checkbox :label="option.id" v-for="option in channelPositions">{{option.name}}</el-checkbox>
                    </el-checkbox-group>
                </el-form-item>

              <el-form-item>
                <el-button type="primary" @click="doSubmit">确定</el-button>
              </el-form-item>
            </el-form>
          </div>
        </div>
      </div>
  </div>
</template>
<script>
  import uConfig from "sysStore/ueditor"
  import VueUEditorWrap from 'vue-ueditor-wrap'
  import {mapGetters} from 'vuex'
  import api from 'sysApi'

  import TreeSelect from '@riophae/vue-treeselect'
  import '@riophae/vue-treeselect/dist/vue-treeselect.css'

  export default {
    name: 'cmsChannel',
    data() {
      return {
        checkList:[],
        optionalTemplatePath: [],
        channelPositions: [],
        customProps: {
          children: 'children',
          label: 'name'
        },
        title: '添加子栏目',
        showChildren: true,
        channelForm:{
          id: null,
          model_id: '',
          parent_id: null,
          name: null,
          positions:[]
        },
        customChannelFields: [],
        uConfig: uConfig,
        channelsTree: []
      }
    },
    watch:{
        ['channelForm.model_id'](val){
            this.loadTemplatePath(val)
        }
    },
    components:{
        'vue-ueditor-wrap':VueUEditorWrap,
        TreeSelect
    },
    computed:{
        ...mapGetters([
            'loading',
            'channels',
            'channelChildren',
            'models',
            'parentChannel',
        ])
    },
    methods: {
        //tree select 节点数据适应
        normalizer(node) {
            return {
                id: node.id,
                label: node.name,
                children: node.children
            }
        },
      async loadTemplatePath(model_id){
            let {data} = await api.getOptionalTemplatePath({model_id});
            this.optionalTemplatePath = data;
        },
      addChannel(row){
        this.showChildren = false;
        this.channelForm = Object.assign({}, {
          id: null,
          parent_id: row.id,
          model_id: '',
          channel_id: null,
          name: null,
          positions: []
        });
        this.$store.dispatch(this.$types.cmsParentChannel, row)
        this.customChannelFields = []
      },
      editChannel(row){
        this.getChannelWhole(row)
        this.showChildren = false;

        this.$store.dispatch(this.$types.cmsCurrentChannel, row)
      },
      deleteChannel(row){
        this.$confirm('确定删除“'+row.name+'”栏目?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deleteCmsChannel({id: row.id})
          if(res.success){
            this.$store.dispatch(this.$types.cmsChannels, [row.parent_id, 0]);
            this.showChildren = true;
            this.$message.success('删除成功!');
          }else{
            this.$message.error(res.error);
          }
        }).catch(()=>{});
      },
      handleNodeClick(node, ...$params){
        if(node.children.length>0){
          this.$store.dispatch(this.$types.cmsChannelChildren, node.id);
          this.showChildren = true;
          this.$store.dispatch(this.$types.cmsParentChannel, node)
        }else{
          this.showChildren = false;
          this.getChannelWhole(node)
        }
      },
      doSubmit(){
        if(!this.channelForm.id){
          this.doAdd()
        }else{
          this.doEdit()
        }
      },
      doCancel(){
        this.showChildren = true;
      },
      async doAdd(){
        this.showChildren = false
        let res = await api.saveCmsChannel(this.channelForm)
        if(res.success){
          this.showChildren = true;
          this.$store.dispatch(this.$types.cmsChannels, [this.parentChannel.id, 0]);
          this.$message.success('添加成功!');
        }else{
          this.$message.error('添加失败!'+res.error);
        }
      },
      async doEdit(){
        let res = await api.saveCmsChannel(this.channelForm)
        if(res.success){
          this.$message.success('修改成功!');
          this.$store.dispatch(this.$types.cmsChannels, [this.channelForm.parent_id, 0]);
        }else{
          this.$message.warning('修改失败!'+res.error);
        }
      },
      async getChannelWhole({id}){
        let res = await api.getCmsChannelWhole({id})
        let whole = res.data;
        this.channelForm = {}
        let baseFields = ['id', 'model_id', 'parent_id', 'name', 'title', 'keywords', 'description', 'template', 'content_template'];

        baseFields.forEach( field => {this.$set(this.channelForm, field, whole[field])} );

        if(whole.contents && whole.contents.length){
          whole.contents.forEach( item => {this.$set(this.channelForm, item.field, item.value)} );
        }

        if(whole.metas && whole.metas.length){
          whole.metas.forEach( item => {this.$set(this.channelForm, item.field, item.value)});
        }

        if(whole.positions){
            this.$set(this.channelForm, 'positions', whole.positions)
        }
      },
      async loadChannelPositions(){
          let res = await api.getCmsPositions({is_channel: 1})
          this.channelPositions = res.data
      }

    },
    async mounted() {
      this.$store.dispatch(this.$types.cmsChannels);
      this.$store.dispatch(this.$types.cmsModels);
      await this.loadChannelPositions()
    },
    watch:{
        channels(val){

            let root = JSON.parse(JSON.stringify(val))[0]
            if(!Object.keys(this.parentChannel).length){
                this.$store.dispatch(this.$types.cmsParentChannel, JSON.parse(JSON.stringify(root)))
            }
            //处理数据 适应TreeSelect组件
            const removeEmptyChildren = function(data){
                if(!data.children.length){
                    data.children = undefined
                }else{
                    for(let child of data.children){
                        removeEmptyChildren(child)
                    }
                }
            }
            if(root){
                removeEmptyChildren(root)
                this.channelsTree = [root]
            }
        },
      async ['channelForm.model_id'](val){
        await this.loadTemplatePath(val)
        if(val){
          if(this.models.length > 0){
            this.models.forEach( model => {
              if(model.id == this.channelForm.model_id){
                this.customChannelFields = model.fields.filter( field => {
                  if(field.is_channel){
                    // 不覆盖主表中存储的字段
                    if(!this.channelForm.hasOwnProperty(field.field)){
                        this.$set(this.channelForm, field.field, '')
                        if(field.type == 'checkbox'){
                            this.$set(this.channelForm, field.field, [])
                        }
                    }
                  }
                  return field.is_channel;
                })
              }
            });
          }
        }else{
          // 不设置任何自定义表单项
          this.customChannelFields = []
        }
      }
    }
  }
</script>


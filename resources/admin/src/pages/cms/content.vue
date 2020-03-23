<style lang="less" scoped>
  .l-content-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 50px - 20px);
    margin:-20px 0 -20px -20px;
    overflow-x: hidden;
    .l-tree-content{
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-flow: row nowrap;
      box-sizing: border-box;
      width: calc(100% - 240px);
    }
  }
</style>
<template>
  <div class="l-content-list">
    <div v-title="'内容管理'"></div>
    <channel-tree :selectedKey="channel_id" @nodeClick="handleNodeClick"></channel-tree>
    <div class="l-tree-content">
        <div class="l-block" v-if="!showForm">
          <div class="l-block-header" v-if="parentChannel">
            <div><i class="iconfont">&#xe64c;</i> {{parentChannel.hasOwnProperty('name') ? parentChannel.name : ''}}</div>
            <el-button type="primary" size="small" @click="addContent">新增</el-button>
          </div>
          <div class="l-block-body">
            <el-table
              :data="contents"
              style="width: 100%">
              <el-table-column
                prop="id"
                label="ID"
                width="80">
              </el-table-column>
              <el-table-column
                prop="title"
                label="标题">
              </el-table-column>
              <el-table-column
                prop="channel.name"
                label="栏目">
              </el-table-column>
              <el-table-column
                label="操作">
                <template slot-scope="scope">
                  <el-button type="text" @click="editContent(scope.row)">编辑</el-button>
                  <el-button type="text" @click="deleteContent(scope.row)">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </div>
    </div>
  </div>
</template>
<script>
  import channelTree from "./components/channelTree";
  import VueUeditorWrap from 'vue-ueditor-wrap';
  import ueditorConfig from "../../store/ueditor";
  import imageUpload from "@/components/imageUpload"
  import multipleImageUpload from "@/components/multipleImageUpload"
  import {mapGetters} from 'vuex'
  import api from '../../api/index'

  export default {
    data() {
      return {
        checkList:[],
        showSwitch: false,
        contents: [],
        showForm: false,
        formTitle: '添加文章',
        form:{
            positions:[]
        },
        ueditorConfig: ueditorConfig,
        contentPositions: [],
        channel_id: 0
      }
    },
    components:{
      'channel-tree': channelTree,
      VueUeditorWrap,
      imageUpload,
      multipleImageUpload
    },
    computed:{
      ...mapGetters([
          'parentChannel',
          'currentChannel',
          'currentModel',
      ]),
    },
    watch:{
      currentChannel(val, oldVal){
        this.loadContents()
      },
      showForm(){
        this.$store.dispatch('collapse');
      },
      async channel_id(val){
          if(val){
              console.log(`.........newVal:`, val)
              let {data} = await api.getCmsChannelWhole({id: val})
              this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, data);
              this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, data)
          }
      }
    },
    methods: {
      goback(){
        this.showForm = false;
      },
      async editContent(row){
          this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, row.channel);
          this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, row.channel);
          this.$router.push('/cms/content/edit?content_id='+row.id);
      },
      deleteContent(row){
        this.$confirm('确定删除文章?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deleteContent({id: row.id})
          this.$message({
            type: 'success',
            message: '删除成功!'
          });
          await this.loadContents()
        });
      },
      async handleNodeClick(node, ...params){
        this.showForm = false;
        let channel = node[0]
        this.channel_id = channel.id
      },
      async addContent(){
          this.$router.push('/cms/content/add?channel_id='+this.currentChannel.id)
      },
      async loadContents(){
        let res = await api.getChannelContents({channel_id: this.channel_id})
        this.contents = res.data;
      },
    },
    async created() {
      this.channel_id = parseInt(this.$route.query.channel_id || 0);
      let {data} = await api.getCmsChannelWhole({id: this.channel_id})
      await this.loadContents()
      this.$store.dispatch('collapse');
    }
  }
</script>


<style lang="less" scoped>
  .l-content-list{
    display: flex;
    flex-flow: row nowrap;
    min-height: calc(100vh - 40px - 20px);
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
            <div>
              <i class="iconfont">&#xe632;</i> {{contentCurrentChannel && contentCurrentChannel.hasOwnProperty('name') ? contentCurrentChannel.name : ''}} <span style="color: #fff;"></span>
            </div>
          </div>
          <div class="l-block-body">
            <div class="l-search-area" style="border-bottom: 1px solid #EBEEF5;">
              <el-form ref="form" :model="form" :inline="true" size="small">
                <el-form-item label="标题">
                  <el-input v-model="form.keyword" style="width: 200px;"></el-input>
                </el-form-item>
                <el-form-item>
                  <el-button type="default" @click="search"><i class="if">&#xe604;</i> 搜索</el-button>
                </el-form-item>
                <el-form-item>
                  <el-button type="primary" size="small" @click="addContent"><i class="if">&#xe663;</i> 新增</el-button>
                </el-form-item>
              </el-form>
            </div>
            <el-table
              :data="contents"
              style="width: 100%">
              <el-table-column
                prop="id"
                label="ID"
                width="80">
              </el-table-column>
              <el-table-column
                label="标题">
                <template slot-scope="scope">
                  <a v-if="scope.row.link" :href="scope.row.link" target="_blank" class="l-a-same">{{scope.row.title}}</a>
                  <span v-else>{{scope.row.title}}</span>
                </template>
              </el-table-column>
              <el-table-column
                prop="channel.name"
                width="160"
                label="栏目">
              </el-table-column>
              <el-table-column
                width="180"
                label="操作">
                <template slot-scope="scope">
                  <el-button type="primary" @click="editContent(scope.row)" size="mini">编辑</el-button>
                  <el-button type="danger" @click="deleteContent(scope.row)" size="mini">删除</el-button>
                </template>
              </el-table-column>
            </el-table>
            <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
          </div>
        </div>
    </div>
  </div>
</template>
<script>
  import channelTree from "../components/channelTree"
  import imageUpload from "@/components/imageUpload"
  import multipleImageUpload from "@/components/multipleImageUpload"
  import pager from "@/components/pager"
  import {mapGetters} from 'vuex'
  import api from 'sysApi'

  export default {
      name: 'cmsContent',
    data() {
      return {
        checkList:[],
        showSwitch: false,
        contents: [],
        showForm: false,
        formTitle: '添加文章',
        form:{
//          positions:[]
            keyword: ''
        },
//        contentPositions: [],
        channel_id: 0,
        page:1,
        page_size: 8,
        total: 0
      }
    },
    components:{
        'channel-tree': channelTree,
        imageUpload,
        multipleImageUpload,
        pager
    },
    computed:{
      ...mapGetters([
          'parentChannel',
          'contentCurrentChannel',
          'currentChannel',
          'currentModel',
          'channels'
      ])
    },
    watch:{
      channels(val){
          let root = JSON.parse(JSON.stringify(val))[0]
          if(!Object.keys(this.parentChannel).length){
              this.$store.dispatch(this.$types.cmsParentChannel, JSON.parse(JSON.stringify(root)))
          }
      },
      currentChannel(val){
        if(val && !this.channel_id){
            this.channel_id = val.id
        }
      },
      contentCurrentChannel(val){
          if(val && Object.keys(val).length){
              this.loadContents()
          }
      },
      showForm(){
        //this.$store.dispatch('collapse')
      },
      async channel_id(val, old){
          if(val){
              this.page = 1
              this.form.keyword = ''
              let {data} = await api.getCmsChannelWhole({id: val})
              this.$store.dispatch(this.$types.cmsContentCurrentChannel, data)
              //this.$store.dispatch(this.$types.cmsParentChannel, data)
          }
      }
    },
    methods: {
      search(){
        let keyword = this.form.keyword
        this.loadContents({keyword})
      },
      async editContent(row){
          this.$router.push('/cms/content/edit?content_id='+row.id);
      },
      deleteContent(row){
        this.$confirm('确定删除文章?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(async () => {
          let res = await api.deleteContent({id: row.id})
          this.$message.success('删除成功!');
          await this.loadContents()
        });
      },
      async handleNodeClick(node, ...params){
          this.showForm = false
          let channel = node[0]
          this.channel_id = channel.id
      },
      async addContent(){
          let channel_id = this.channel_id || this.contentCurrentChannel.id
          this.$router.push('/cms/content/add?channel_id='+channel_id)
      },
      async loadContents({...params}){
          let queryData = {channel_id: this.channel_id, page: this.page, page_size: this.page_size, ...params}
          let {data} = await api.getChannelContents(queryData)
          if(data.contents){
              this.contents = data.contents;
          }
          this.total = parseInt(data.total) || 0;
      },
      async currentChange(page){


      }
    },
    async created() {
      let channel_id = this.$route.query.channel_id || 0;
      this.channel_id = channel_id;
      await this.loadContents()
    }
  }
</script>


<template>
  <div>
    <div v-title="'面板'"></div>
    <!--<el-alert-->
            <!--title="提个醒"-->
            <!--type="warning"-->
            <!--style="margin-bottom: 20px;">-->
      <!--<div slot="default">-->
            <!--<p>看天上这朵云像不像你欠我的200块钱</p>-->
      <!--</div>-->
    <!--</el-alert>-->
    <div>
      <!--<TreeChart :json="treeData" />-->
      <button @click="collapse">折叠</button>
      <button @click="expand">打开</button>
      <js-mind id="js-mind-123" :values="mind" :options="options" ref="jsMind" height="1000px"></js-mind>
    </div>
    <!--<el-card class="row-20" shadow="hover">-->
      <!--<div slot="header" class="clearfix">-->
        <!--<span>我的技术栈</span>-->
      <!--</div>-->
      <!--<div>-->
        <!--<el-row :gutter="20">-->
          <!--<el-col :span="6"><div class="grid-content" style="background: #4fa8ed">PHP</div></el-col>-->
          <!--<el-col :span="6"><div class="grid-content" style="background: #ad97da">Javascript</div></el-col>-->
          <!--<el-col :span="6"><div class="grid-content" style="background: #3fc0c2">Python</div></el-col>-->
          <!--<el-col :span="6"><div class="grid-content" style="background: #f6d33a">CSS</div></el-col>-->
        <!--</el-row>-->
      <!--</div>-->
    <!--</el-card>-->
  </div>

</template>
<script>
  import VueUeditorWrap from 'vue-ueditor-wrap';
  import ueditorConfig from "../store/ueditor";
  import TreeChart from "vue-tree-chart";
  import Vue from 'vue'
  import jm from 'vue-jsmind'

  Vue.use(jm)

  export default {
    data(){
      return {
        index: 'some_random_string',
        content: '这是我设置的默认文本...',
        treeData: {
            name: '总经办',
            image_url: "http://jetcdn.larashop.com/uploads/11.jpg",
            class: ["rootNode"],
            children: [
                {
                    name: '财务部',
                    image_url: "http://jetcdn.larashop.com/uploads/11.jpg"
                },
                {
                    name: '产品研发事业部',
                    image_url: "http://jetcdn.larashop.com/uploads/11.jpg",
                    mate: {
                        name: '牛逼部门',
                        image_url: "http://jetcdn.larashop.com/uploads/11.jpg"
                    },
                    children: [
                        {
                            name: '电学开发组',
                            image_url: "http://jetcdn.larashop.com/uploads/11.jpg"
                        },
                        {
                            name: '软件开发组',
                            image_url: "http://jetcdn.larashop.com/uploads/11.jpg",
                            children: [
                                {
                                    name: '路章',
                                    image_url: 'http://jetcdn.larashop.com/uploads/11.jpg'
                                },
                                {
                                    name: '王XX',
                                    image_url: 'http://jetcdn.larashop.com/uploads/11.jpg'
                                },
                                {
                                    name: '吴XX',
                                    image_url: 'http://jetcdn.larashop.com/uploads/11.jpg'
                                },
                                {
                                    name: 'ETC.',
                                    image_url: 'http://jetcdn.larashop.com/uploads/11.jpg'
                                }
                            ]
                        },
                        {
                            name: '测试组',
                            image_url: "http://jetcdn.larashop.com/uploads/11.jpg"
                        }
                    ]
                },
                {
                    name: '采购库管部',
                    image_url: "http://jetcdn.larashop.com/uploads/11.jpg"
                }
            ]
        },
        mind: {
            "meta":{
                "name":"jsMind remote",
                "author":"hizzgdev@163.com",
                "version":"0.2"
            },
            "format":"node_tree",
            "data":{"id":"root","topic":"思纳福","children":[
                {"id":"easy","topic":"产品研发事业部","direction":"right","children":[
                    {"id":"easy1","topic":"电子学开发组", "children": [
                        {"id": "easy11", "topic": "谭玉坤"},
                        {"id": "easy12", "topic": "华震"},
                        {"id": "easy13", "topic": "孙代玉"},
                        {"id": "easy14", "topic": "丁逸"},
                        {"id": "easy15", "topic": "李春雷"},
                    ]},
                    {"id":"easy2","topic":"软件开发组"},
                    {"id":"easy3","topic":"测试组"},
                    {"id":"easy4","topic":"加工组"},
                    {"id":"easy5","topic":"机械设计组"},
                    {"id":"easy6","topic":"中试组"},
                ]},
                {"id":"open","topic":"总经办","direction":"right","children":[
                    {"id":"open1","topic":"盛广济"},
                    {"id":"open2","topic":"孙筱"}
                ]},
                {"id":"powerful","topic":"财务部","direction":"right","children":[
                    {"id":"powerful1","topic":"乔丽丽"},
                ]},
                {"id":"other","topic":"人事行政部","direction":"right","children":[
                    {"id":"other1","topic":"缪小雨"},
                    {"id":"other2","topic":"李梅"}
                ]}
            ]}
        },
        options: {
            container : 'js-mind-123',         // [必选] 容器的ID
            editable : true,       // 是否启用编辑
            theme : 'primary',           // 主题
            mode :'side',           // 显示模式
            support_html : true,    // 是否支持节点里的HTML元素
            view:{
                engine: 'canvas',   // 思维导图各节点之间线条的绘制引擎
                hmargin:100,        // 思维导图距容器外框的最小水平距离
                vmargin:50,         // 思维导图距容器外框的最小垂直距离
                line_width:2,       // 思维导图线条的粗细
                line_color:'#555'   // 思维导图线条的颜色
            },
            layout:{
                hspace:30,          // 节点之间的水平间距
                vspace:20,          // 节点之间的垂直间距
                pspace:13           // 节点与连接线之间的水平间距（用于容纳节点收缩/展开控制器）
            },
            shortcut:{
                enable:true,        // 是否启用快捷键
                handles:{},         // 命名的快捷键事件处理器
                mapping:{           // 快捷键映射
                    addchild   : 45,    // <Insert>
                    addbrother : 13,    // <Enter>
                    editnode   : 113,   // <F2>
                    delnode    : 46,    // <Delete>
                    toggle     : 32,    // <Space>
                    left       : 37,    // <Left>
                    up         : 38,    // <Up>
                    right      : 39,    // <Right>
                    down       : 40,    // <Down>
                }
            },
        }
      }
    },
    computed: {
      ueditorConfig(){
        return ueditorConfig
      }
    },
    components: {
      VueUeditorWrap,
      TreeChart,
    },
    watch:{
      content(){}
    },
    methods:{
      setUeditor(instance, index){
      },
      getContent(){
        this.content = 'fffffff';
      },
      collapse(){
          let jm = window.jsMind.current
          jm.collapse_node('easy')
      },
      expand(){
          let jm = window.jsMind.current
          jm.expand_node('easy')
      }
    },
    created() {

    }
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
  #js-mind-123 /deep/ #jsmind_container{
    display: none;
  }
</style>

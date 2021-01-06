<template>
  <div>
    <div v-title="'面板'"></div>
    <el-alert
            title="提醒"
            type="warning"
            style="margin-bottom: 20px;">
      <div>
            <p>这里放一些提醒信息</p>
      </div>
    </el-alert>
    <!--<el-button @click="throttledArrowClick">点我</el-button>-->
    <div style="position: relative;width: 600px;height: 600px;">
      <process-tree-vue :treeData="treeData"></process-tree-vue>
    </div>
  </div>

</template>
<script>
    import throttle from 'throttle-debounce/throttle';
    import processTreeVue from 'process-tree-vue'

  export default {
    name: 'dashboard',
    data(){
        return {
            editableTabsValue: '1',
            editableTabs: [{
                title: 'Tab 1',
                name: '1',
                content: 'Tab 1 content'
            }, {
                title: 'Tab 2',
                name: '2',
                content: 'Tab 2 content'
            }],
            tabIndex: 2,
            treeData:[{
                    name:'节点1',
                    children:[
                        {name:'节点5'},
                        {name:'节点5',isLong:true},
                        {name:'节点26',children:[
                                {name:'节点3'},
                                {name:'节点3'},
                                {name:'节点33',
                                    children:[
                                        {name:'节点3'},
                                        {name:'节点3'},
                                        {name:'➤节点3'}
                                    ]
                                }
                            ]},
                        {name:'节点3',children:[{name:'节点3'},{name:'节点3'}]},
                        {name:'节点4',children:[{name:'节点3'}]},
                        {name:'节点5',isLong:true},
                    ]
                }]
        }
    },
    components: {
        processTreeVue
    },
    watch:{
    },
    methods:{
        doSomeThing(){
            console.log(`-------------1234-------------\n`)
        },
        addTab(targetName) {
            let newTabName = ++this.tabIndex + '';
            this.editableTabs.push({
                title: 'New Tab',
                name: newTabName,
                content: 'New Tab content'
            });
            this.editableTabsValue = newTabName;
        },
        removeTab(targetName) {
            let tabs = this.editableTabs;
            let activeName = this.editableTabsValue;
            if (activeName === targetName) {
                tabs.forEach((tab, index) => {
                    if (tab.name === targetName) {
                        let nextTab = tabs[index + 1] || tabs[index - 1];
                        if (nextTab) {
                            activeName = nextTab.name;
                        }
                    }
                });
            }

            this.editableTabsValue = activeName;
            this.editableTabs = tabs.filter(tab => tab.name !== targetName);
        }
    },
    async created(){
        this.throttledArrowClick = throttle(5000, true,  _ => {
            this.doSomeThing()
        });
    }
  }
</script>
<style lang="less" scoped>
  .grid-content{
    color: #fff;
    border-radius: 6px;
    padding: 20px 30px;
  }
  .l-month-select{
    border-bottom: 1px solid #f1f1f1;
    padding-bottom: 10px;
    margin-bottom: 10px;
    ul{
      display: flex;
      flex-flow: row nowrap;
      justify-content: flex-start;
      li{
        float: left;
        cursor: pointer;
        border: 1px solid #eee;
        border-radius: 3px;
        padding: 3px 8px;
        margin-right: 10px;
        &.active{
          color: #fff;
          border-color: #293c55;
          background-color: #293c55;
        }
      }
    }
  }
</style>


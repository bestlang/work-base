<template>
    <el-tabs v-model="editableTabsValue" type="card" closable @tab-remove="removeTab" @tab-click="clickTab">
        <el-tab-pane
                v-for="(item, index) in editableTabs"
                :key="item.name"
                :label="item.title"
                :name="item.name"
        >
        </el-tab-pane>
    </el-tabs>
</template>

<script>
    export default {
        data(){
            return {
                editableTabsValue: 'dashboard',
                editableTabs: [
                    {
                        title: '面板',
                        name: 'dashboard',
                        path: '/',
                        fullPath: '/'
                    }
                ]
            }
        },
        watch:{
            $route(){
                this.addTab()
            }
        },
        methods:{
            addTab(){
                let mcs = this.$router.getMatchedComponents()
                let path = this.$route.path
                let fullPath = this.$route.fullPath
                let name = mcs[mcs.length-1].name
                // ["name","meta","path","hash","query","params","fullPath","matched"]
                const exists = this.editableTabs.map(tab => tab.name).includes(name)
                if(!exists){
                    this.editableTabs.push({
                        title: this.$route.meta.name,
                        name: name,
                        path: path,
                        fullPath: fullPath
                    })
                }
                this.editableTabsValue = name
            },
            clickTab(currentTab){
                const [tab] = this.editableTabs.filter(tab => tab.name == currentTab.name)
                this.$router.push(tab.fullPath)
            },
            removeTab(targetName) {
                let tabs = this.editableTabs
                let activeName = this.editableTabsValue
                if (activeName === targetName) {
                    tabs.forEach((tab, index) => {
                        if (tab.name === targetName) {
                            let nextTab = tabs[index + 1] || tabs[index - 1]
                            if (nextTab) {
                                activeName = nextTab.name
                                const [tab] = this.editableTabs.filter(tab => tab.name == activeName)
                                this.$router.replace(tab.fullPath)
                            }else{
                                this.$router.replace('/')
                            }
                        }
                    });
                }
                this.editableTabsValue = activeName
                this.editableTabs = tabs.filter(tab => tab.name !== targetName)
            }
        },
        created(){
           this.addTab()
        }

    }
</script>
<style lang="less" scoped>
    /deep/ .el-tabs__nav{
        border-top: none!important;
    }
    /deep/ .el-tabs__nav .el-tabs__item{
        &.is-active{
            background: #fff;
        }
    }
</style>
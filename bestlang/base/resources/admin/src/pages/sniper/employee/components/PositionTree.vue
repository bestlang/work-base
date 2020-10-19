<template>
    <div class="l-tree-container">
        <view v-if="title">{{title}}</view>
        <el-tree
                @node-click="handleNodeClick"
                icon-class="el-icon-caret-right"
                :default-expand-all="true"
                ref="tree"
                :data="treeData"
                node-key="id"
                :props="customProps"
                :highlight-current="true"
                :expand-on-click-node="false">
                <span class="custom-tree-node" slot-scope="{ node, data }">
                  <span><span v-if="!data.children.length" class="iconfont">&#xe92a;</span>{{ node.label }}</span>
                </span>
        </el-tree>
    </div>
</template>
<style lang="less">
    .custom-tree-node {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
       font-weight: lighter;
    }
    .el-tree-node__content{
        box-sizing: content-box;
        padding: 2px 0;
    }
</style>
<script>
    import api from "sysApi"
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                customProps: {
                    children: 'children',
                    label: 'name'
                },
                treeData:[]
            }
        },
        props:{
            title:{
                type: String,
                default: ''
            },
            selectedKey:{
                type: Number,
                default: 0
            }
        },
        watch:{},
        computed:{
            ...mapGetters([]),
        },
        methods:{
            handleNodeClick(node){
                this.$emit('nodeClick', node);
            }
        },
        async mounted() {
            let res = await  api.sniperGetPositionDescendants()
            if(!res.hasError){
                this.treeData =  [Object.values(res.data)[0]];
                this.$emit('treeLoaded', this.treeData[0])
            }
        }
    }
</script>

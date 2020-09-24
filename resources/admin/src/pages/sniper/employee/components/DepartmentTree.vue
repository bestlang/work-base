<style lang="less">
    .l-tree-container{
        padding: 10px 20px;
        border-right: 1px solid #f4f4f4;
        min-height: calc(100vh - 50px - 20px);
        box-sizing: border-box;

    }
    .custom-tree-node{
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 17px;
    }
    .el-tree-node__content{
        box-sizing: content-box;
        padding: 2px 0;
    }
</style>
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
<script>
    import api from "@/api/index"
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
            // selectedKey:{
            //     type: Number,
            //     default: 0
            // },
            updated:{
                type: Number,
                default: 0
            }
        },
        watch:{
            async updated(){
                await this.updateTree()
            }
        },
        computed:{
            ...mapGetters([]),
        },
        methods:{
            handleNodeClick(node){
                this.$emit('nodeClick', node);
            },
            async updateTree(){
                let res = await  api.sniperGetDepartmentDescendants()
                if(res.data){
                    this.treeData = [Object.values(res.data)[0]]
                    this.$emit('treeLoaded', this.treeData[0])
                }
            }
        },
        async mounted() {
            await this.updateTree()
        }
    }
</script>

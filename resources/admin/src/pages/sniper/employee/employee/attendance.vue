<template>
    <div class="l-position-list">
        <div v-title="'考勤记录'"></div>
        <ding-department-tree  @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded" :updated="updated"></ding-department-tree>
        <div class="l-block">
            <div class="l-block-header">
                111
            </div>
            <div class="l-block-body">
                    blablabla
            </div>
        </div>

    </div>
</template>
<script>
    import DingDepartmentTree from "../components/DingDepartmentTree"
    export default {
        components:{
            DingDepartmentTree
        },
        data(){
            return {
                updated: 0
            }
        },
        computed:{

        },
        methods:{
            handleNodeClick(node){
                // this.department = node
                // this.assignForm(node)
                console.log(node)
            },
            performTreeLoaded(department){
                // this.department = department
                // this.assignForm(department)
            },
        }
    }
</script>
<style scoped lang="less">
    .l-position-list{
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
            overflow-y: auto;
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
    .l-block{
        padding-left: 20px;
    }
    .l-department-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-department{
            position: relative;
            box-shadow: #67C23A;
            height: 140px;
            border:1px solid #f1f1f1;
            width: 220px;
            margin: 20px 30px 0 0;
            border-radius: 2px;
            cursor: pointer;
            background: #F2F8FE;
            &:hover{
                box-shadow: 3px 3px 6px #FAFAFA;
                background: #fcf8e3;
                h1{
                    color: #2d2d2d;
                }
            }
            h1{
                font-size: 16px;
                color: #777;
                padding: 10px 0 0 10px;
                font-weight: bold;
            }
            .l-employee-count{
                color: #4c110f;
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 14px;
            }
        }
    }
</style>
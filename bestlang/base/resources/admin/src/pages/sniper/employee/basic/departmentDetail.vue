<template>
    <div>
        <div v-title="'部门详情'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统 / <span @click="viewDepartment" style="cursor: pointer;">部门管理</span> / 部门详情</span>
                </div>
            </div>
            <div class="l-block-body l-content-list">

                <department-tree  :selectedKey="2" @nodeClick="handleNodeClick"  :parent_id="id"></department-tree>
                <div class="l-tree-content">
                    <div class="l-display">
                        <div><b>部门名称：</b>{{department.name}}</div>
                        <div><b>部门经理：</b>{{department.manager}}</div>
                        <div v-if="department.parent"><b>上级部门：</b>{{department.parent.name}}</div>
                        <div><el-button type="primary" @click="editDepartment(department)">修改</el-button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DepartmentTree from "../components/DepartmentTree"
    import api from 'sysApi'
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        name: 'sniperEmployeeBasicDepartmentDetail',
        components: { TreeSelect, DepartmentTree },
        data(){
            return {
                id: 0,
                sub_id: 0,
                value: null,
                department:{},
                departments: []
             }
        },
        watch:{
            id(val){
                this.getDepartmentDetail(val)
            },
            sub_id(val){
                this.getDepartmentDetail(val)
            },
        },
        methods:{
            editDepartment({id}){
                this.$router.push('/sniper/employee/department/edit?id='+id)
            },
            handleNodeClick(node){
                this.sub_id = node[0].id
            },
            async getDepartmentDetail(id){
                let res = await api.sniperGetDepartmentDetail({id});
                this.department = res.data
            },
            viewDepartment(){
                this.$router.push('/sniper/employee/department')
            }
        },
        async mounted(){
            this.id = parseInt(this.$route.query.id || 0);
        }
    }
</script>

<style scoped lang="less">
    .l-content-list{
        display: flex;
        flex-flow: row nowrap;
        min-height: calc(100vh - 50px - 20px - 45px);
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
    .l-display{
        line-height: 50px;
    }
</style>
<template>
	<div class="l-department-list">
        <div v-title="'部门管理'"></div>
        <!--:selectedKey="2"-->
        <department-tree class="l-tree" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded" :updated="updated"></department-tree>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <!--<span>员工系统 / 部门管理</span>-->
                    <span><i class="iconfont">&#xe69a;</i> {{department.hasOwnProperty('name') ? department.name : ''}}</span>
                    <el-button-group>
                    <el-button v-permission="'hr add departments'" v-if="showForm" type="primary" @click="save" size="small">保存</el-button>
                    <el-button v-permission="'hr edit departments'" v-if="!showForm" type="primary" @click="edit" size="small">编辑</el-button>
                    <el-button v-permission="'hr delete departments'" type="danger" @click="remove" size="small">删除</el-button>
                    <el-button v-permission="'hr add departments'" type="success" @click="add" size="small"><i class="iconfont">&#xe663;</i>新增</el-button>
                    </el-button-group>
                </div>
            </div>
            <div class="l-block-body">
                <div v-if="showForm">
                    <el-form ref="form" :model="form" label-width="80px" style="width: 50%;overflow-y: visible">
                        <el-form-item label="部门名称">
                            <el-input v-model="form.name"></el-input>
                        </el-form-item>
                        <el-form-item label="上级部门">
                            <tree-select v-model="form.parent_id" :multiple="false" :options="departments"  :default-expand-level="10" :normalizer="normalizer" />
                        </el-form-item>
                        <el-form-item label="经    理">
                            <el-input v-model="form.manager"></el-input>
                        </el-form-item>
                    </el-form>
                </div>
                <div v-if="department.children && department.children.length" style="margin-top: 20px;">
                    <el-divider content-position="left">直属部门</el-divider>
                    <div class="l-department-wrap">
                        <div class="l-department" v-for="(department, index) in department.children" @click="departmentDetail(department)" :key="index">
                            <h1 class="l-title">{{department.name}}</h1>
                            <article class="l-employee-count">
                                <!--<b>2</b> 人-->
                                <!--<i class="iconfont">&#xe69a;</i>-->
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</template>
<script>
    import DepartmentTree from "../components/DepartmentTree"
    import TreeSelect from '@riophae/vue-treeselect'
    import api from "sysApi"
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

	export default {
        name: 'sniperEmployeeBasicDepartment',
        components: { DepartmentTree, TreeSelect },
        data(){
            return {
                updated: 0,
                department: {},
                departments:[],
                departmentsTree:[],
                form: {
                    id: '',
                    name: '',
                    parent_id: null,
                    manager: '',
                },
            }
        },
        computed:{
            showForm(){
                return true;//!(this.department.children && this.department.children.length)
            }
        },
        methods:{
            async saveDepartment(){
                let res = await api.sniperSaveDepartment(this.form)
                return res
            },
            remove(){
                let id = this.department.id
                this.$confirm('确定删除部门?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.sniperDeleteDepartment({id})
                    if(!res.hasError){
                        this.showMessage('删除成功！', 'success')
                        this.updated = Math.random()
                    }
                });
            },
            edit(){
                this.assignForm(this.department)
            },
            async save(){
                let res = await this.saveDepartment()
                if(res.hasError){
                    this.showMessage(res.error)
                }else{
                    this.showMessage('更新成功！', 'success')
                   this.updated = Math.random()//Math.floor(Math.random() * 999999)
                }
            },
            assignForm(department){
                this.form.id = department.id
                this.form.name = department.name
                this.form.parent_id = department.parent_id
                this.form.manager = department.manager
            },
            //tree select 节点数据适应
            normalizer(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.children,
                }
            },
            handleNodeClick(node){
                this.department = node
                this.assignForm(node)
                console.log(node)
            },
            performTreeLoaded(department){
                this.department = department
                this.assignForm(department)
            },
            departmentDetail(department){
                this.department = department
                this.assignForm(department)
                //this.$router.push('/sniper/employee/department/detail?id='+id)
            },
            add(){
                let {id} = this.department
                this.$router.push('/sniper/employee/department/edit?parent_id='+id)
            },
            async getDepartmentsTree(){
                this.departments = []
                let res = await api.sniperGetDepartmentsTreeSelect()
                let root = Object.values(res.data)[0]
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
                    this.departments = [root]
                }
            },
        },
        async mounted(){
            await this.getDepartmentsTree()
        }
	}
</script>
<style scoped lang="less">
    .l-department-list{
        display: flex;
        flex-flow: row nowrap;
        min-height: calc(100vh - 50px - 20px);
        margin:-20px 0 -20px -20px;
        overflow-x: hidden;
        .l-tree{
            flex-shrink: 0;
            padding: 10px 20px;
            border-right: 1px solid #f4f4f4;
            overflow-y: auto;
            width: 280px;
        }
    }
    .l-block{
        flex-shrink: 20;
        padding-left: 20px;
        width: 1800px;
    }
    .l-department-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-department{
            position: relative;
            box-shadow: #67C23A;
            height: 80px;
            border:1px solid #f1f1f1;
            width: 200px;
            margin: 20px 30px 0 0;
            border-radius: 2px;
            cursor: pointer;
            background: #F2F8FE;
            &:hover{
                box-shadow: 3px 3px 6px #FAFAFA;
                background: #fcf8e3;
                h1{
                    color: #888;
                }
            }
            h1{
                font-size: 14px;
                color: #888;
                padding: 10px 0 0 10px;
                font-weight: bold;
                font-weight: lighter;
            }
            .l-employee-count{
                color: #555;
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 14px;
            }
        }
    }
    @media screen and (max-width: 1500px) {
        .l-department-wrap{
            .l-department{
                width: 192px;
            }
        }
    }
</style>
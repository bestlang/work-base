<template>
    <div>
        <div v-title="'新增部门'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统 / <span @click="viewDepartments" style="cursor: pointer;">部门管理</span> / 新增部门</span>
                    <el-button type="primary" @click="save">保存</el-button>
                </div>
            </div>
            <div class="l-block-body">

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
        </div>
    </div>
</template>

<script>
    import api from '@/api/index'
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        components: { TreeSelect },
        data(){
            return {
                value: null,
                form: {
                    id: 0,
                    name: '',
                    parent_id: null,
                    manager: '',
                },
                departments: [],
            }
        },
        watch:{
           async  ['form.id'](val){
                await this.getDepartmentDetail(val)
            }
        },
        methods:{
            async getDepartmentDetail(id){
                let {data} = await api.sniperGetDepartmentDetail({id});
                this.form.id = data.id
                this.form.name = data.name
                this.form.parent_id = data.parent_id
                this.form.manager = data.manager
            },
            //tree select 节点数据适应
            normalizer(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.children,
                }
            },
            viewDepartments(){
                this.$router.push('/sniper/employee/department')
            },
            async save(){
                let res = await this.saveDepartment()
                if(res.hasError){
                    this.showMessage(res.error)
                }else{
                    this.showMessage('添加成功！', 'success')
                    this.$router.push('/sniper/employee/department')
                }
            },
            async getDepartments(){
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
                removeEmptyChildren(root)
                this.departments = [root]
            },
            async saveDepartment(){
                let res = await api.sniperSaveDepartment(this.form)
                return res
            }
        },
        async mounted(){
            this.getDepartments()
            this.form.id = parseInt(this.$route.query.id) || 0;
            let parent_id = parseInt(this.$route.query.parent_id) || 0;
            if(parent_id){
                this.form.parent_id = parent_id
            }
        }
    }
</script>

<style scoped lang="less">
.el-form-item__content  /deep/  .vue-treeselect__menu-container{
    z-index: 9999;
}
</style>
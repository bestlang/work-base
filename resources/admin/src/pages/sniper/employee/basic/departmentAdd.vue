<template>
    <div>
        <div v-title="'新增部门'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统 / 部门管理 / 新增部门</span>
                    <el-button type="primary" @click="save">保存</el-button>
                </div>
            </div>
            <div class="l-block-body">

                <el-form ref="form" :model="form" label-width="80px" style="width: 50%;overflow-y: visible">
                    <el-form-item label="部门名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="上级部门">
                        <tree-select v-model="form.parent_id" :multiple="false" :options="departments"  :default-expand-level="10" />
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
                    name: '',
                    parent_id: null,
                    manager: '',
                },
                departments: [],
            }
        },
        methods:{
            async save(){
                let res = await this.saveDepartment()
                if(res.hasError){
                    this.showMessage(res.error)
                }else{
                    this.showMessage('添加成功！', 'success')
                }
            },
            async getDepartments(){
                let res = await api.sniperGetDepartments({})
                this.departments = [Object.values(res.data)[0]]
            },
            async saveDepartment(){
                let res = await api.sniperSaveDepartment(this.form)
                return res
            }
        },
        async mounted(){
            this.getDepartments()
        }
    }
</script>

<style scoped lang="less">
.el-form-item__content  /deep/  .vue-treeselect__menu-container{
    z-index: 9999;
}
</style>
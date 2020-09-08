<template>
    <div>
        <div v-title="'添加职位'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统 / <span @click="viewPositions" style="cursor: pointer;">职位管理</span> / 添加职位</span>
                    <el-button type="primary" @click="save">保存</el-button>
                </div>
            </div>
            <div class="l-block-body">

                <el-form ref="form" :model="form" label-width="100px" style="width: 50%;overflow-y: visible">
                    <el-form-item label="职位名称">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="所属部门">
                        <tree-select v-model="form.department_id" :multiple="false" :options="departments"  :default-expand-level="10" :normalizer="normalizer" />
                    </el-form-item>
                    <el-form-item label="上级职位">
                        <tree-select v-model="form.parent_id" :multiple="false" :options="positions"  :default-expand-level="10" :normalizer="normalizer" />
                    </el-form-item>
                    <el-form-item label="所需员工数">
                        <el-input v-model="form.desiring"></el-input>
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

    const removeEmptyChildren = function(data){
        if(!data.children.length){
            data.children = undefined
        }else{
            for(let child of data.children){
                removeEmptyChildren(child)
            }
        }
    }

    export default {
        components: { TreeSelect },
        data(){
            return {
                value: null,
                form: {
                    id: '',
                    name: '',
                    department_id: null,
                    parent_id: null,
                    desiring: '',
                },
                departments: [],
                positions: []
            }
        },
        watch:{
            async  ['form.id'](val){
                await this.getPositionDetail(val)
            }
        },
        methods:{
            async getPositionDetail(id){
                let {data} = await api.sniperGetPositionDetail({id});
                this.form.id = data.id
                this.form.name = data.name
                this.form.department_id = data.department_id
                this.form.desiring = data.desiring
            },
            //tree select 节点数据适应
            normalizer(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.children,
                }
            },
            viewPositions(){
                this.$router.push('/basic/position')
            },
            async save(){
                let res = await this.savePosition()
                if(res.hasError){
                    this.showMessage(res.error)
                }else{
                    this.showMessage('添加成功！', 'success')
                    this.$router.push('/basic/position')
                }
            },
            async getDepartments(){
                let res = await api.sniperGetDepartmentsTreeSelect({})
                let root = Object.values(res.data)[0]
                //处理数据 适应TreeSelect组件
                // const removeEmptyChildren = function(data){
                //     if(!data.children.length){
                //         data.children = undefined
                //     }else{
                //         for(let child of data.children){
                //             removeEmptyChildren(child)
                //         }
                //     }
                // }
                removeEmptyChildren(root)
                this.departments = [root]
            },
            async getPositions(){
                let res = await api.sniperGetPositionsTreeSelect({})
                let root = Object.values(res.data)[0]
                //处理数据 适应TreeSelect组件
                // const removeEmptyChildren = function(data){
                //     if(!data.children.length){
                //         data.children = undefined
                //     }else{
                //         for(let child of data.children){
                //             removeEmptyChildren(child)
                //         }
                //     }
                // }
                removeEmptyChildren(root)
                this.positions = [root]
            },
            async savePosition(){
                let res = await api.sniperSavePosition(this.form)
                return res
            }
        },
        async mounted(){
            await this.getDepartments()
            await this.getPositions()
            this.form.id = parseInt(this.$route.query.id) || '';
        }
    }
</script>

<style scoped lang="less">
    .el-form-item__content  /deep/  .vue-treeselect__menu-container{
        z-index: 9999;
    }
</style>
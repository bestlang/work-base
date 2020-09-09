<template>
    <div>
        <div v-title="'新增员工'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统  / 添加员工</span>
                    <el-button type="primary" @click="save" size="small">保存</el-button>
                </div>
            </div>
            <div class="l-block-body">

                <el-form ref="form" :model="form" label-width="120px" style="width: 50%;overflow-y: visible">
                    <el-form-item label="所属部门">
                        <tree-select v-model="form.department_id" :multiple="false" :options="departments"  :default-expand-level="10" :normalizer="normalizer" />
                    </el-form-item>
                    <!--<el-form-item label="标签">-->
                    <!--<el-input v-model="form.tag"></el-input>-->
                    <!--</el-form-item>-->
                    <el-form-item label="职位">
                        <tree-select v-model="form.position_id" :multiple="false" :options="positions"  :default-expand-level="10" :normalizer="normalizer" />
                    </el-form-item>
                    <el-form-item label="真实姓名">
                        <el-input v-model="form.name"></el-input>
                    </el-form-item>
                    <el-form-item label="性别">
                        <div>
                            <el-radio v-model="form.gender" label="1" border>男</el-radio>
                            <el-radio v-model="form.gender" label="2" border>女</el-radio>
                        </div>
                    </el-form-item>
                    <el-form-item label="头像">
                        <image-upload v-model="form.avatar"></image-upload>
                    </el-form-item>
                    <el-form-item label="手机号">
                        <el-input v-model="form.phone"></el-input>
                    </el-form-item>

                    <!--<el-form-item label="工作地点">-->
                        <!--<el-input v-model="form.work_place"></el-input>-->
                    <!--</el-form-item>-->

                    <!--<el-form-item label="籍贯">-->
                        <!--<el-input v-model="form.native_land"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="生日">-->
                        <!--<el-input v-model="form.birthday"></el-input>-->
                    <!--</el-form-item>-->
                    <el-form-item label="身份证号">
                        <el-input v-model="form.id_card"></el-input>
                    </el-form-item>
                    <el-form-item label="公司邮箱">
                        <el-input v-model="form.email"></el-input>
                    </el-form-item>
                    <el-form-item label="初始密码">
                        <el-input type="password" v-model="form.password" auto-complete="new-password"></el-input>
                    </el-form-item>
                    <!--<el-form-item label="学校">-->
                        <!--<el-input v-model="form.school"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="学习时间">-->
                        <!--<el-input v-model="form.study_duration"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="学位">-->
                        <!--<el-input v-model="form.degree"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="婚姻状况">-->
                        <!--<el-input v-model="form.marital"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="配偶">-->
                        <!--<el-input v-model="form.mate"></el-input>-->
                    <!--</el-form-item>-->
                    <!--<el-form-item label="子女数量">-->
                        <!--<el-input v-model="form.children"></el-input>-->
                    <!--</el-form-item>-->
                    <el-form-item label="紧急联系人">
                        <el-input v-model="form.emergency"></el-input>
                    </el-form-item>
                    <el-form-item label="紧急联系人电话">
                        <el-input v-model="form.emergency_phone"></el-input>
                    </el-form-item>
                </el-form>
                <!--<el-divider content-position="left">扩展资料</el-divider>-->
                <!--<el-form ref="form" :model="form" label-width="100px" style="width: 50%;overflow-y: visible">-->
                <!--</el-form>-->
            </div>
        </div>
    </div>
</template>

<script>
    import api from '@/api/index'
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    import imageUpload from "@/components/imageUpload"

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
        components: { TreeSelect, imageUpload },
        data(){
            return {
                value: null,
                form: {
                    user_id: 0,
                    real_name: '',
                    department_id: null,
                    tag: null,
                    position_id: null,
                    phone: '',
                    work_place: '',
                    gender: 0,
                    native_land: '',
                    birthday: '',
                    id_card: '',
                    email: '',
                    password: '111111',
                    school: '',
                    study_duration: '',
                    degree: '',
                    marital: '',
                    mate: '',
                    children: '',
                    emergency:'',
                    emergency_phone:'',
                    avatar: ''
                },
                departments: [],
                positions: []
            }
        },
        watch:{

        },
        methods:{
            assignForm(position){
                this.form.id = position.id
                this.form.name = position.name
                this.form.department_id = position.department_id
                this.form.parent_id = position.parent_id
                this.form.desiring = position.desiring
                this.form.jd = position.jd
            },
            async getPositionDetail(id){
                let {data} = await api.sniperGetPositionDetail({id});
                this.assignForm(data)
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
                let res = await api.sniperSaveEmployee(this.form)
                if(!res.hasError){
                    this.showMessage('添加成功！', 'success')
                    this.$router.push('/basic/employee/list')
                }else{
                    this.showMessage(res.error, 'error')
                }
            },
            async getDepartments(){
                let res = await api.sniperGetDepartmentsTreeSelect({})
                let root = Object.values(res.data)[0]
                //处理数据 适应TreeSelect组件
                removeEmptyChildren(root)
                this.departments = [root]
            },
            async getPositions(){
                let res = await api.sniperGetPositionsTreeSelect({})
                let root = Object.values(res.data)[0]
                //处理数据 适应TreeSelect组件
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
            this.form.id = parseInt(this.$route.query.id) || 0;
            let department_id = parseInt(this.$route.query.department_id) || 0;
            if(department_id){
                this.form.department_id = department_id;
            }
        }
    }
</script>

<style scoped lang="less">
    .el-form-item__content  /deep/  .vue-treeselect__menu-container{
        z-index: 9999;
    }
</style>
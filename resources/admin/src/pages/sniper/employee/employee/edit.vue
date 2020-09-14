<template>
    <div>
        <div v-title="'编辑员工'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>员工系统  / {{bread_title}}</span>
                    <el-button type="primary" @click="save" size="small">保存</el-button>
                </div>
            </div>
            <div class="l-block-body">
                <el-tabs v-model="activeName" @tab-click="handleClick" type="border-card">
                    <el-tab-pane label="基本信息" name="basic">
                        <el-form ref="form" :model="form" label-width="130px" style="width: 50%;overflow-y: visible;padding-top: 20px;">
                            <el-form-item label="所属部门*">
                                <tree-select v-model="form.department_id" :multiple="false" :options="departments"  :default-expand-level="10" :normalizer="normalizer" />
                            </el-form-item>
                            <el-form-item label="职位*">
                                <tree-select v-model="form.position_id" :multiple="false" :options="positions"  :default-expand-level="10" :normalizer="normalizer" />
                            </el-form-item>
                            <el-form-item label="真实姓名*">
                                <el-input v-model="form.real_name"></el-input>
                            </el-form-item>
                            <el-form-item label="性别*">
                                <div>
                                    <el-radio v-model="form.gender" :label="1" border>男</el-radio>
                                    <el-radio v-model="form.gender" :label="2" border>女</el-radio>
                                </div>
                            </el-form-item>
                            <el-form-item label="头像">
                                <image-upload v-model="form.avatar"></image-upload>
                            </el-form-item>
                            <el-form-item label="手机号*">
                                <el-input v-model="form.phone"></el-input>
                            </el-form-item>
                            <el-form-item label="身份证号">
                                <el-input v-model="form.id_card"></el-input>
                            </el-form-item>
                            <el-form-item label="公司邮箱">
                                <el-input v-model="form.email"></el-input>
                            </el-form-item>
                            <el-form-item label="初始密码">
                                <el-input type="password" v-model="form.password" auto-complete="new-password" :placeholder="passwordHolder"></el-input>
                            </el-form-item>
                            <el-form-item label="紧急联系人">
                                <el-input v-model="form.emergency"></el-input>
                            </el-form-item>
                            <el-form-item label="紧急联系人手机号">
                                <el-input v-model="form.emergency_phone"></el-input>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label="扩展信息" name="extend">
                        <el-form ref="form" :model="form" label-width="130px" style="width: 50%;overflow-y: visible;padding-top: 20px;">
                            <el-form-item label="婚姻状况">
                                <el-input v-model="form.marital"></el-input>
                            </el-form-item>
                            <el-form-item label="配偶姓名">
                                <el-input v-model="form.mate"></el-input>
                            </el-form-item>
                            <el-form-item label="子女数">
                                <el-input v-model="form.children"></el-input>
                            </el-form-item>
                            <el-form-item label="工作地点">
                                <el-input v-model="form.work_place"></el-input>
                            </el-form-item>
                            <el-form-item label="籍贯">
                                <el-input v-model="form.native_land"></el-input>
                            </el-form-item>
                            <el-form-item label="生日">
                                <el-input v-model="form.birthday"></el-input>
                            </el-form-item>
                            <el-form-item label="标签">
                            <el-input v-model="form.tag"></el-input>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label="教育经历" name="education">
                        <div class="l-flex">
                            <div><i>从最高学历开始填写</i></div>
                            <el-button type="primary" icon="el-icon-plus" circle style="margin-bottom: 10px;" @click="addEducation"></el-button>
                        </div>
                        <div style="overflow-y: visible;">
                            <el-table
                                    border
                                    :data="form.educationHistory"
                                    style="width: 100%">
                                <el-table-column
                                        label="起止时间"
                                        width="200px">
                                    <template slot-scope="scope">
                                        {{scope.row.start_time}} ~ {{scope.row.end_time}}
                                    </template>
                                </el-table-column>
                                <el-table-column
                                        prop="school"
                                        label="学校"
                                        width="220">
                                </el-table-column>
                                <el-table-column
                                        prop="specialize"
                                        label="专业">
                                </el-table-column>
                                <el-table-column
                                        prop="degree"
                                        label="学位">
                                </el-table-column>
                                <el-table-column
                                        label="是否统招*">
                                    <template slot-scope="scope">
                                        {{scope.row.unified ? '是':'否'}}
                                    </template>
                                </el-table-column>
                                <el-table-column
                                        label="操作">
                                    <template slot-scope="scope">
                                        <el-button type="text" @click="editEducation(scope.row)">编辑</el-button>
                                        <el-button type="text" @click="delEducation(scope.row)">删除</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                            <education style="margin-top: 20px;" v-show="showEducationFlag" :default-data="education" @cancel="hideEducationForm" @submit="restoreEducation"></education>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="工作经历" name="jobs">
                        <div class="l-flex">
                            <div><i>从最近工作经历开始填写</i></div>
                            <el-button type="primary" icon="el-icon-plus" circle style="margin-bottom: 10px;" @click="addJob"></el-button>
                        </div>
                            <el-table
                                    border
                                    :data="form.jobHistory"
                                    style="width: 100%">
                                <el-table-column
                                        label="起止时间"
                                        width="200px">
                                    <template slot-scope="scope">
                                        {{scope.row.start_time}} ~ {{scope.row.end_time}}
                                    </template>
                                </el-table-column>
                                <el-table-column
                                        prop="company"
                                        label="公司"
                                        width="220">
                                </el-table-column>
                                <el-table-column
                                        prop="position"
                                        label="岗位">
                                </el-table-column>
                                <el-table-column
                                        prop="salary"
                                        label="薪酬">
                                </el-table-column>
                                <el-table-column
                                        prop="reason"
                                        label="离职原因">
                                </el-table-column>
                                <el-table-column
                                        prop="witness_phone"
                                        label="证明人电话">
                                </el-table-column>
                                <el-table-column
                                        label="操作">
                                    <template slot-scope="scope">
                                        <el-button type="text" @click="editJob(scope.row)">编辑</el-button>
                                        <el-button type="text" @click="delJob(scope.row)">删除</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                        <job style="margin-top: 20px;" v-show="showJobFlag" :default-data="job" @cancel="hideJobForm" @submit="restoreJob"></job>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '@/api/index'
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    import imageUpload from "@/components/imageUpload"
    import Education from '../components/Education'
    import Job from '../components/Job'

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
        components: { TreeSelect, imageUpload, Education, Job },
        data(){
            return {
                activeName: 'education',
                bread_title: '新增员工',
                value: null,
                passwordHolder: '',
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
                    avatar: '',
                    educationHistory: [],
                    jobHistory: []
                },
                departments: [],
                positions: [],
                education: {
                    id: '',
                    start_time: null,
                    end_time: null,
                    school: null,
                    specialize: null,
                    degree: null,
                    unified: 1
                },
                job: {
                    id: '',
                    start_time: null,
                    end_time: null,
                    company: null,
                    position: null,
                    salary: 0,
                    reason: '',
                    witness_phone: ''
                },
                showEducationFlag: false,
                showJobFlag: false,
            }
        },
        watch:{
            async ['form.user_id'](val){
                await this.getEmployeeDetail(val)
            }
        },
        methods:{
            showEducationForm(){
                this.showEducationFlag =  true
            },
            hideEducationForm(){
                this.showEducationFlag = false
            },
            showJobForm(){
                this.showJobFlag =  true
            },
            hideJobForm(){
                this.showJobFlag = false
            },
            assignEducationForm(education){
                this.education.id = education.id
                this.education.start_time = education.start_time
                this.education.end_time = education.end_time
                this.education.school = education.school
                this.education.specialize = education.specialize
                this.education.specialize = education.specialize
                this.education.degree = education.degree
                this.education.unified = education.unified
            },
            assignJobForm(job){
                this.job.id = job.id
                this.job.start_time = job.start_time
                this.job.end_time = job.end_time
                this.job.company = job.company
                this.job.position = job.position
                this.job.salary = job.salary
                this.job.reason = job.reason
                this.job.witness_phone = job.witness_phone
            },
            addEducation(){
                this.showEducationForm()
                this.education.id = 'temp_' + Math.random().toString().substr(2)
                this.education.start_time = ''
                this.education.send_time = ''
                this.education.school = ''
                this.education.specialize = ''
                this.education.degree = ''
                this.education.unified = 1
            },
            addJob(){
                this.showJobForm()
                this.job.id = 'temp_' + Math.random().toString().substr(2)
                this.job.start_time = ''
                this.job.send_time = ''
                this.job.company = ''
                this.job.position = ''
                this.job.salary = ''
                this.job.reason = ''
                this.job.witness_phone = ''
            },
            editEducation(row){
                this.showEducationForm()
                this.assignEducationForm(row)
            },
            editJob(row){
                this.showJobForm()
                this.assignJobForm(row)
            },
            delEducation(row){
                this.$confirm('确定删除本条教育经历?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let user_id = this.form.user_id
                    let id = row.id
                    let res = await api.sniperDeleteEmployeeEducation({user_id, id})
                    if(!res.hasError){
                        let selectedIndex = -1
                        for(let idx in this.form.educationHistory){
                            if(this.form.educationHistory[idx].id == row.id){
                                selectedIndex = idx
                                break
                            }
                        }
                        if(selectedIndex != -1){
                            this.form.educationHistory.splice(selectedIndex, 1)
                        }
                    }
                })
            },
            delJob(row){
                this.$confirm('确定删除本条工作经历?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let user_id = this.form.user_id
                    let id = row.id
                    let res = await api.sniperDeleteEmployeeJob({user_id, id})
                    if(!res.hasError){
                        let selectedIndex = -1
                        for(let idx in this.form.jobHistory){
                            if(this.form.jobHistory[idx].id == row.id){
                                selectedIndex = idx
                                break
                            }
                        }
                        if(selectedIndex != -1){
                            this.form.jobHistory.splice(selectedIndex, 1)
                        }
                    }
                })
            },
            //暂存教育信息
            restoreEducation(education){
                let found = false
                for(let idx in this.form.educationHistory){
                    if(this.form.educationHistory[idx].id == education.id){
                        let theOne = this.form.educationHistory[idx]
                        theOne.start_time = education.start_time
                        theOne.end_time = education.end_time
                        theOne.school = education.school
                        theOne.specialize = education.specialize
                        theOne.degree = education.degree
                        theOne.unified = education.unified
                        found = true
                        break
                    }
                }
                if(!found){//没找到
                    this.form.educationHistory.push(education)
                }

                this.hideEducationForm()
                this.showMessage('点击“保存”按钮存储教育经历', 'info')
            },
            restoreJob(job){
                let found = false
                for(let idx in this.form.jobHistory){
                    if(this.form.jobHistory[idx].id == job.id){
                        let theOne = this.form.jobHistory[idx]
                        theOne.start_time = job.start_time
                        theOne.end_time = job.end_time
                        theOne.company = job.company
                        theOne.position = job.position
                        theOne.salary = job.salary
                        theOne.reason = job.reason
                        theOne.witness_phone = job.witness_phone
                        found = true
                        break
                    }
                }
                if(!found){//没找到
                    this.form.jobHistory.push(job)
                }

                this.hideJobForm()
                this.showMessage('点击“保存”按钮存储工作经历', 'info')
            },
            handleClick(tab, event) {
                console.log(tab, event);
            },
            assignForm(employee){
                    this.form.user_id = employee.user_id
                    this.form.real_name = employee.real_name
                    this.form.department_id = employee.department_id
                    //this.form.tag = employee.tag
                    this.form.position_id = employee.position_id
                    this.form.phone = employee.phone

                    this.form.gender = employee.gender

                    this.form.id_card = employee.id_card
                    this.form.email = employee.user.email
                    this.form.password = undefined

                    this.form.emergency = employee.emergency
                    this.form.emergency_phone = employee.emergency_phone
                    this.form.avatar = employee.avatar
                    //extend
                    this.form.marital = employee.marital
                    this.form.mate = employee.mate
                    this.form.children = employee.children
                    this.form.work_place = employee.work_place
                    this.form.native_land = employee.native_land
                    this.form.birthday = employee.birthday
                    // education
                    this.form.educationHistory = employee.education
                    // job
                    this.form.jobHistory = employee.job

            },
            async getEmployeeDetail(id){
                let {data} = await api.sniperGetEmployeeDetail({id})
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
                this.$router.push('/sniper/employee/position')
            },
            async save(){
                let res = await api.sniperSaveEmployee(this.form)
                if(!res.hasError){
                    let msg = !this.form.user_id ? '添加成功' : '更新成功'
                    this.showMessage(msg, 'success')
                    this.$router.push('/sniper/employee/employee/list')
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
            this.form.id = parseInt(this.$route.query.id) || 0
            let department_id = parseInt(this.$route.query.department_id) || 0
            if(department_id){
                this.form.department_id = department_id
            }
            let employee_id = parseInt(this.$route.query.employee_id) || 0
            if(employee_id){
                this.form.user_id = employee_id
                this.bread_title = '编辑员工'
                this.passwordHolder = '不修改密码请留空'
            }
        }
    }
</script>

<style scoped lang="less">
    .el-form-item__content  /deep/  .vue-treeselect__menu-container{
        z-index: 9999;
    }
</style>
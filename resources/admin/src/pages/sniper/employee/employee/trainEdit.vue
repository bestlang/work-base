<template>
    <div>
        <div v-title="'新增/编辑培训'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <div>
                        <span class="l-go-back" @click="goBack"><span class="iconfont">&#xe601;</span>返回</span>
                        <el-divider direction="vertical"></el-divider>
                        <span>新增/编辑培训</span>
                    </div>

                    <el-button size="small" type="primary" @click="handleSubmit"><i class="if">&#xe9d3;</i> 保存</el-button>
                </div>
            </div>
            <div class="l-block-body">
                <el-tabs type="border-card" v-model="activeName">
                    <el-tab-pane label="培训信息" name="lesson">
                        <el-form ref="form" :model="form" label-width="80px" size="small">
                            <el-form-item label="培训名称">
                                <el-input v-model="form.title"></el-input>
                            </el-form-item>
                            <el-form-item label="培训内容">
                                <el-input v-model="form.content"></el-input>
                            </el-form-item>
                            <el-form-item label="开始日期">
                                <el-date-picker
                                        v-model="form.start_time"
                                        type="datetime"
                                        placeholder="选择开始日期"
                                        align="right"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                        :picker-options="pickerOptions">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="结束日期">
                                <el-date-picker
                                        v-model="form.end_time"
                                        type="datetime"
                                        placeholder="选择结束日期"
                                        align="right"
                                        value-format="yyyy-MM-dd HH:mm:ss"
                                        :picker-options="pickerOptions">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="持续时间">
                                <el-form :inline="true"  class="demo-form-inline" size="small">
                                    <el-form-item>
                                        <el-input v-model="form.last_days" type="number"><template slot="append">天</template></el-input>
                                    </el-form-item>
                                    <el-form-item>
                                        <el-input v-model="form.last_hours" type="number"><template slot="append">小时</template></el-input>
                                    </el-form-item>
                                    <el-form-item>
                                        <el-input v-model="form.last_minutes" type="number"><template slot="append">分钟</template></el-input>
                                    </el-form-item>
                                </el-form>
                            </el-form-item>
                            <el-form-item label="讲师">
                                <el-input v-model="form.teacher"></el-input>
                            </el-form-item>
                            <el-form-item label="培训地点">
                                <el-input v-model="form.location"></el-input>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane label="参与人员" name="member">
                        <div>
                            <el-button type="primary" icon="el-icon-plus" size="small" circle style="margin-bottom: 10px;" @click="handleAddParticipant"></el-button>
                        </div>
                        <div class="l-participant-item" v-for="u in form.participants">
                            <div class="l-flex" style="line-height: 30px;">
                                <div>
                                    <p>{{u.split('-')[1]}}</p>
                                    <p class="l-dept">{{u.split('-')[2]}}</p>
                                </div>
                                <!--<small style="color: #ccc;">- {{u.split('-')[2]}}</small>-->
                                <span @click.stop="handleRemoveParticipant(u)" class="hover-show-remove">移除</span>
                            </div>
                        </div>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
        <el-drawer
                title="人员选择"
                :visible.sync="drawer"
                :with-header="false"
                :append-to-body="true"
                :show-close="true"
                size="80%">
            <div class="user-wrap">
                <div v-for="(gu, dept) in groupedUser">
                    <h4 style="color: #5d5d5d;padding: 5px 0;">{{dept}}</h4>
                    <p>
                        <span @click="selectThisUser(u, dept)" class="user-to-select" :class="{active: form.participants.indexOf(u.sniperUser.id+'-'+u.name+'-'+dept) !== -1}" v-for="u in gu">
                            {{u.name}}
                            <div class="tri"><i class="if">&#xe6bd;</i></div>
                        </span>
                    </p>
                </div>
                <div class="l-add-buttons">
                    <el-button type="primary" size="small" @click="handleConfirmAdd">确定</el-button>
                    <!--<el-button type="default" size="small"><i class="if">&#xe625;</i></el-button>-->
                </div>
            </div>
        </el-drawer>
    </div>
</template>
<script>
    import api from 'sysApi'

    export default {
        name: 'sniperEmployeeTrainEdit',
        data(){
            return {
                drawer: false,
                groupedUser: {},
                users: [],
                activeName: 'lesson',
                keyword: '',
                form:{
                        id: 0,
                        title: '',
                        content: '',
                        start_time: null,
                        end_time: null,
                        last_days: 0,
                        last_hours: 0,
                        last_minutes: 0,
                        teacher: '',
                        location: '',
                        participants:[]
                },
                pickerOptions: {
                    shortcuts: [{
                        text: '今天',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: '昨天',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '一周前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                }
            }
        },
        methods:{
            goBack(){
                this.$store.dispatch("tagNav/removeCurrentTagNav", this.$route.path)
                this.$router.push('/train');
            },
            handleRemoveParticipant(u){
                let name = u.split('-')[1];
                this.$confirm('确定移除'+name+'?').then(() => {
                    let idx = this.form.participants.indexOf(u)
                    this.form.participants.splice(idx, 1)
                }).catch(() => {

                });
            },
            handleSearch(){},
            handleAdd(){},
            async handleSubmit(){
                let res = await api.sniperSaveEmployeeTrain(this.form)
                if(res.hasError){
                    this.$message.error(res.error)
                }else{
                    this.$message.success('操作成功！')
                    this.goBack()
                }
            },
            handleAddParticipant(){
                this.drawer = true;
            },
            handleConfirmAdd(){
                this.drawer = false;
            },
            async getDepartmentUsers(){
                let res = await api.sniperDingGetDepartmentUsers({all: 0})
                if(res && res.data){
                    this.users = res.data
                }
            },
            selectThisUser(u, dept){
                let userId = u.sniperUser.id + '-' + u.name + '-' + dept;
                if(this.form.participants.indexOf(userId) === -1){
                    this.form.participants.push(userId);
                }else{
                    let idx = this.form.participants.indexOf(userId)
                    this.form.participants.splice(idx, 1)
                }
            },
            async getTrainDetail(id){
                let {data} = await api.sniperEmployeeTrainDetail({id});
                for(let key in data){
                    if(key != 'participants'){
                        this.form[key] = data[key]
                    }else if(key == 'participants'){
                        let participants = []
                        let p = data[key]
                        for(let idx in p){
                            let item = p[idx].id + '-' + p[idx].name + '-' + p[idx].employee.department.name;
                            participants.push(item)
                        }
                        this.form['participants'] = participants
                    }
                }
            }
        },
        watch:{
            users(val){
                let groupedUser = {}
                val.forEach((user) => {
                    groupedUser[user.department_info] = groupedUser[user.department_info] || []
                    groupedUser[user.department_info].push(user)
                });
                this.groupedUser = groupedUser
                console.log(groupedUser)
            },
        },
        components: {},
        async created() {
            let id = this.$route.query.id || 0;
            this.form.id = parseInt(id)
            if(id){
                await this.getTrainDetail(id)
            }
            await this.getDepartmentUsers()

        }
    }
</script>
<style scoped>
/deep/ .el-form--inline .el-form-item{
    margin-bottom: 0;
}
</style>
<style lang="less" scoped>
    .l-participant-item{
        min-height: 60px;
        width: 280px;
        display: inline-block;
        background: #fcf8e3;
        border:1px solid #e6db74;
        padding: 0 15px;
        line-height: 30px;
        margin-right: 20px;
        margin-bottom: 20px;
        .hover-show-remove{
            letter-spacing: 2px;font-size: 80%;cursor: pointer;
            display: none;
        }
        .l-dept{
            font-size: 80%;
            color: orange;
        }

        &:hover{
            box-shadow: 3px 3px 6px #f1f1f1;
            background: #F5F7FA;
            border: 1px solid #E4E7ED;
            .hover-show-remove{
                display: block;
            }
        }
    }
    .l-add-buttons{
        position: absolute;right: 20px;top:10px;
    }
    .user-wrap{
        padding: 0 20px;overflow-y: scroll;height: 100%;
        position: relative;
    }
    .user-to-select {
        box-sizing: border-box;cursor:pointer;display: inline-block;margin-right: 20px;padding: 3px 20px;background-color: #efefef;border: 2px solid #f1f1f1;
        position: relative;
        &.active{
            border: 2px solid #1b4b72!important;
            .tri{
                display: block;
            }
        }
        .tri{
            width: 8px;
            height: 8px;
            position: absolute;
            border-bottom: 8px solid #1b4b72;
            border-right: 8px solid #1b4b72;
            border-top: 8px solid transparent;
            border-left: 8px solid transparent;
            right: 0;
            bottom: 0;
            display: none;
            .if{
                font-size: 8px;
                background: transparent;
                color: #f1f1f1;
                position: absolute;
                top: -2px;
                left: -2px;
            }
        }
    }
</style>
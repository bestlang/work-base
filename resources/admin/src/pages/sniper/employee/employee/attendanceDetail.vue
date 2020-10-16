<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>人力资源 / <router-link to="/sniper/employee/employee/attendance">考勤记录</router-link>  / {{user.name ? user.name:''}}考勤详情</span>
                </div>
            </div>
        </div>
        <el-card shadow="hover">
            <el-calendar @input="dateChange">
                <template
                        slot="dateCell"
                        slot-scope="{date, data}">
                    <p style="font-size: 18px;font-weight: 300;">
                        {{ data.day.split('-').slice(1).join('/') }}
                    </p>
                    <div v-show="showResult(data.day) && timeLine(data.day)">
                        <el-progress  :percentage="50"  :show-text="false" stroke-linecap="square" :stroke-width="4" color="#ccc"></el-progress>
                        <el-progress  style="margin-top: 2px" :percentage="timeLine(data.day) * 50"  :show-text="false" stroke-linecap="square" :stroke-width="4" color="#293c55"></el-progress>
                    </div>
                    <div v-show="showResult(data.day)" style="font-size: 12px;color: #5a5e66">
                        <p><span v-html="readable(data.day).onDutyTimeResult"></span><span>{{readable(data.day).onDutyTime}}</span></p>
                        <p><span v-html="readable(data.day).offDutyTimeResult"></span><span>{{readable(data.day).offDutyTime}}</span></p>
                        <p><span v-html="readable(data.day).leaveResult"></span></p>
                    </div>

                </template>
            </el-calendar>
        </el-card>
        <div><i style="color: #555;">{{month}}月份</i></div>
        <div style="border-top: 1px solid #ccc;display: flex;flex-flow: row nowrap;justify-content: space-between" v-if="user">
            <div><b style="color: #555;">{{user.name}}</b><i style="color: #aaa;"><{{user.orgEmail}}></i> <span style="color: #fff;">{{user.userid}}</span></div>
            <div style="color: #555;font-style: italic">{{user.department_info?user.department_info.name:''}}</div>
        </div>
        <el-card v-if="graph" shadow="hover">
            <el-button @click="filterRest">-法休</el-button>
            <el-button @click="plusRest">+法休</el-button>
            <v-chart :options="options" style="width: 100%;height: 600px;"/>
        </el-card>
        <div class="l-choose-employee" title="选人查看" @click="chooseEmployee"><i class="iconfont">&#xe602;</i></div>
        <el-drawer
                title="人员选择"
                :visible.sync="drawer"
                :with-header="false"
                :append-to-body="true"
                :show-close="true"
                size="80%">
            <div style="padding: 0 20px;overflow-y: scroll;height: 100%;">
                <div v-for="(gu, dept) in groupedUser">
                    <h4 style="color: #5d5d5d;padding: 5px 0;">{{dept}}</h4>
                    <p>
                        <span @click="viewUser(u.userid)" style="cursor:pointer;display: inline-block;margin-right: 20px;padding: 5px 20px;background-color: #efefef;border: 1px solid #f1f1f1" v-for="u in gu">
                            {{u.name}}
                            <!-- -{{u.userid}}-->
                        </span>
                    </p>
                </div>
            </div>
        </el-drawer>
        <el-card style="margin-top: 20px;" shadow="hover">
            <!--<div>平均每周工作小时</div>-->
            <v-chart :options="optionsTM" style="width: 100%;height: 600px;"/>
        </el-card>
    </div>
</template>
<script>
    import Vue from 'vue'
    import ECharts from 'vue-echarts' // refers to components/ECharts.vue in webpack

    // import ECharts modules manually to reduce bundle size
    import 'echarts/lib/chart/line'
    import 'echarts/lib/chart/bar'
    import 'echarts/lib/chart/scatter'
    import 'echarts/lib/component/title'
    import 'echarts/lib/component/tooltip'
    import 'echarts/lib/component/polar'
    import 'echarts/lib/component/angleAxis'
    import 'echarts/lib/component/legend'

    // register component to use
    Vue.component('v-chart', ECharts)

    import api from "sysApi"

    export default {
        name: 'sniperEmployeeAttendanceDetail',
        data(){
            let anyDate = '2020/9/27 00:00:00'
            return {
                drawer: false,
                direction: 'rtl',
                graph: true,

                userId: null,
                month: null,
                user: {},
                value : new Date(),
                attendances:{},
                users: [],
                groupedUser: {},
                optionsTM:{
                    dataset: {
                        source: [['','个人平均出勤（小时）', '部门平均出勤（小时）']]
                    },
                    color: ['#293c55', '#348498'],
                    grid:{
                        x:'2.2%',
                        y:'5%',
                        x2:'2.4%',
                        y2:'12%',
                        width: '97%',
                    },
                    title: {
                        text: '个人/部门平均出勤对比'
                    },
                    tooltip: {},
                    legend: {
                        data: ['个人平均出勤（小时）', '部门平均出勤（小时）']
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {},
                    series: [{type: 'bar'},{type: 'bar'}]
                },
                options:{
                    title:{
                        text: '打卡趋势'
                    },
                    color:  ['#fdc4b6','#fdc4b6','#001871','#001871'],
                    grid:{
                        x:'2.2%',
                        y:'6%',
                        x2:'2.4%',
                        y2:'12%',
                        width: '96.5%',
                    },
                    yAxis:{
                        interval: 1800000,
                        min: 8 * 60 * 60 * 1000,
                        axisLabel:{
                            formatter:function(a){
                                let now = new Date(new Date(anyDate).getTime() + a)
                                return now.getHours() + now.toLocaleTimeString().substr(-6,3)
                            }
                        }
                    },
                    xAxis:{
                        type:'category',
                        boundaryGap: false
                    },
                    legend: {
                        data: ['上班打卡', '下班打卡', '上班时间', '下班时间']
                    },
                    tooltip:{
                        trigger: 'axis',
                        axisPointer: {
                            type: 'none',
                            label: {
                                backgroundColor: '#6a7985'
                            }
                        },
                        formatter(params){
                            let result = []
                            params.forEach(function(item, index) {
                                if(index >= 2) {
                                    let now = new Date(new Date(anyDate).getTime() + item.value[1])
                                    let str = ''
                                    let x = now.getHours() + now.toLocaleTimeString().substr(-6, 3)
                                    str += '<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:' + item.color + '"></span>';
                                    str += '<span style="font-size: 10px;">' + item.value[0] + item.seriesName + ":" + x + '</span>'
                                    result.push(str)
                                }
                            });
                            return result.join('<br>')
                        }
                    },
                    series:[
                        {
                            name: '上班时间',
                            type: 'line',
                            data: [],
                            dataBak: []
                        },
                        {
                            name: '下班时间',
                            type: 'line',
                            data: [],
                            dataBak: []
                        },
                        {
                            name: '上班打卡',
                            type: 'line',
                            // areaStyle:{color: '#fff'},
                            data: [],
                            dataBak: []
                        },
                        {
                            name: '下班打卡',
                            type: 'line',
                            // areaStyle:{color: '#293c55'},
                            data: [],
                            dataBak: []
                        },

                    ]
                }
            }
        },
        computed:{
            currentMonth(){
                let d = new Date()
                let str = d.getFullYear()
                let m = d.getMonth() + 1
                if(m < 10){
                    m = '0'+m
                }
                str += '-' + m
                return str
            }
        },
        watch:{
            async '$route'(to, from){
                if(to.path == '/sniper/employee/employee/attendance/detail'){
                    this.erase()
                    this.userId = to.query.userId
                    await this.getUser(to.query.userId)
                    await this.getUserAttendance(to.query.userId, this.month)
                    await this.getWeekAvgAttendance()
                }
            },
            users(val){
                let groupedUser = {}
                val.forEach((user) => {
                    groupedUser[user.department_info] || (groupedUser[user.department_info] = [])
                    groupedUser[user.department_info].push(user)
                });
                this.groupedUser = groupedUser
                console.log(groupedUser)
            },
            async userId(val){
                if(val){
                    this.erase()
                    await this.getUser(val)
                }
            },
            async month(val){
                if(!val){
                    this.month = this.currentMonth
                }
                if(this.userId) {
                    this.erase()
                    await this.getUserAttendance(this.userId)
                    await this.getWeekAvgAttendance()
                }
            }
        },
        methods:{
            erase(){
                [0,1,2,3].forEach((i) =>{
                    this.options.series[i].data = []
                    this.options.series[i].dataBak = []
                })
            },
            filterRest(){
                if(!this.options.series[0].dataBak.length){
                    [0,1,2,3].forEach((i) =>{
                        this.options.series[i].dataBak = JSON.parse(JSON.stringify(this.options.series[i].data))
                    })
                }
                let ex = d => {
                   return d.value[2] == 1
                }
                [0,1,2,3].forEach((i) =>{
                    this.options.series[i].data = this.options.series[i].data.filter(ex)
                })
            },
            plusRest(){
                if(this.options.series[0].dataBak.length){
                    [0,1,2,3].forEach((i) =>{
                        this.options.series[i].data = JSON.parse(JSON.stringify(this.options.series[i].dataBak))
                    })
                }
            },
            viewUser(userid){
                this.$router.push(`/sniper/employee/employee/attendance/detail?userId=${userid}`)
                this.drawer = false
            },
            chooseEmployee(){
                this.drawer = true
            },
            handleClose(){},
            async getUser(userId){
                let {data} = await api.sniperDingGetUser({userId})
                this.user = data
            },
            dateChange(row){
                let d = new Date(row)
                let y = d.getFullYear()
                let m = d.getMonth() + 1
                if(m<10){
                    m = '0' + m
                }
                this.month = y + '-' + m

            },
            showResult(day){
                return day.split('-').slice(0, 2).join('-') == this.month
            },
            timeLine(day){
                let a = this.attendances[day] ? this.attendances[day] : ''
                let on = a.OnDuty
                let off = a.OffDuty
                let required = 0;
                let reality = 0;
                if(on && off){
                    required = off.baseCheckTime - on.baseCheckTime
                    reality = off.userCheckTime - on.userCheckTime
                }
                if(required && reality){
                    return reality / required
                }
                return 0
            },
            readable(day){
                const resultMap = {
                    '':'',
                    Normal: '正常',
                    Late: '迟到',
                    Early: '早退',
                    NotSigned: '未打卡</span>'
                }
                let onDutyTimeResult = ''
                let offDutyTimeResult = ''
                let leaveResult = ''
                let onDutyTime = ''
                let offDutyTime = ''
                let onClock = ''
                let offClock = ''
                if(this.attendances[day] && this.attendances[day].OnDuty){
                    onDutyTimeResult = this.attendances[day].OnDuty.timeResult
                    let on = this.attendances[day].OnDuty
                    if(on.approveId || on.procInstId){
                        onDutyTimeResult = 'Normal'
                    }
                    if(this.attendances[day].OnDuty.procInstId || this.attendances[day].OnDuty.approveId){
                        onClock = '<span class="iconfont" title="已关联出差/请假/加班等">&#xe60b;</span>'
                    }
                    onDutyTime = this.attendances[day].OnDuty.hi
                }
                if(this.attendances[day] && this.attendances[day].OffDuty){
                    offDutyTimeResult = this.attendances[day].OffDuty.timeResult
                    let off = this.attendances[day].OffDuty
                    if(off.approveId || off.procInstId){
                        offDutyTimeResult = 'Normal'
                    }
                    if(this.attendances[day].OffDuty.procInstId || this.attendances[day].OffDuty.approveId){
                        offClock = '<span class="iconfont" title="已关联出差/请假/加班等">&#xe60b;</span>'
                    }

                    offDutyTime = this.attendances[day].OffDuty.hi
                }
                if(onDutyTimeResult == 'Late'){
                    let on = this.attendances[day].OnDuty
                    onDutyTimeResult = '<span style="color: #dd7777;font-weight: 700">上班' + resultMap[onDutyTimeResult] + Math.floor((on.userCheckTime - on.baseCheckTime)/1000/60) + '分钟</span>'+onClock
                }else if(onDutyTimeResult == 'NotSigned'){
                    onDutyTimeResult = '<span style="color: orange;font-weight: 700">上班' + resultMap[onDutyTimeResult] + '</span>'+onClock
                }else if(onDutyTimeResult == 'Normal'){
                    onDutyTimeResult = '<span style="color: green;font-weight: 700">上班' + resultMap[onDutyTimeResult] + '</span>'+onClock
                }
                if(offDutyTimeResult == 'Early'){
                    let off = this.attendances[day].OffDuty
                    offDutyTimeResult = '<span style="color: #dd7777;font-weight: 700">下班' + resultMap[offDutyTimeResult] + Math.floor((off.baseCheckTime - off.userCheckTime)/1000/60) + '分钟</span>'+offClock
                }else if(offDutyTimeResult == 'NotSigned'){
                    offDutyTimeResult = '<span style="color: orange;font-weight: 700">下班' + resultMap[offDutyTimeResult] + '</span>'+offClock
                }else if(offDutyTimeResult == 'Normal'){
                    offDutyTimeResult = '<span style="color: green;font-weight: 700">下班' +resultMap[offDutyTimeResult] + '</span>'+offClock
                }

                if(this.attendances[day] && this.attendances[day].leave){
                    let leave = this.attendances[day].leave
                    leaveResult = `<span class="iconfont" title="请假">&#xe60b;</span><span>${leave.start_time.slice(5, -3)}~${leave.end_time.slice(5, -3)}</span>`
                }

                return {
                    onDutyTimeResult,
                    offDutyTimeResult,
                    leaveResult,
                    onDutyTime,
                    offDutyTime
                }
            },
            async getUserAttendance(userId){
                if(!this.month){
                    this.month = this.currentMonth
                }
                let {data} = await api.sniperDingGetUsersAttendance({userIds:[userId], month: this.month})
                let values = Object.values(data)
                this.attendances = values.length > 0 ? values[0] : {}
                if(true){
                    let OnDuty = []
                    let OffDuty = []
                    let OnBase = []
                    let OffBase = []
                    for(let d in this.attendances){
                        let day = this.attendances[d]
                        if(day.OnDuty){
                            OnDuty.push({
                                value: [day.OnDuty.w+day.OnDuty.ymd.slice(8), parseInt(day.OnDuty.userCheckTime) - new Date(`${day.OnDuty.ymd} 00:00:00`), day.OnDuty.workType]
                            })
                            OnBase.push({
                                value: [day.OnDuty.w+day.OnDuty.ymd.slice(8), 9 * 60 * 60 * 1000, day.OnDuty.workType]
                            })
                        }
                        if(day.OffDuty){
                            OffDuty.push({
                                value: [day.OffDuty.w+day.OffDuty.ymd.slice(8), parseInt(day.OffDuty.userCheckTime) - new Date(`${day.OffDuty.ymd} 00:00:00`), day.OffDuty.workType]
                            })
                            OffBase.push({
                                value: [day.OffDuty.w+day.OffDuty.ymd.slice(8), 18 * 60 * 60 * 1000, day.OffDuty.workType]
                            })
                        }
                    }
                    this.erase()
                    this.options.series[0].data = OnBase
                    this.options.series[1].data = OffBase
                    this.options.series[2].data = OnDuty
                    this.options.series[3].data = OffDuty

                }
            },
            async getDepartmentUsers(){
                let res = await api.sniperDingGetDepartmentUsers()
                if(res && res.data){
                    this.users = res.data
                }
            },
            async getWeekAvgAttendance(){
                let res = await api.sniperDingGetWeekAvgAttendance({month: this.month, userId: this.userId})
                let formed  = []
                res.data.forEach(function (item) {
                    formed.push(item)
                })
                this.optionsTM.dataset.source = []
                this.optionsTM.dataset.source.push(...res.data)
            }
        },
        async created(){
            let month = this.$route.query.month || null
            let userId = this.$route.query.userId || null
            // if(month){
            //     this.month = month
            // }
            if(userId){
                this.userId = userId
                await this.getUserAttendance(userId, this.month)
            }
            await this.getDepartmentUsers()
            await this.getWeekAvgAttendance()
        }
    }
</script>
<style  lang="less" scoped>
    .l-my-drawer{
        padding-left: 20px;
    }
    .l-choose-employee{
        cursor: pointer;
        position: fixed;
        z-index: 9999;
        width: 60px;
        height: 60px;
        box-sizing: border-box;
        border-radius: 100px;
        background: #293c55;
        text-align: center;
        color: #fff;
        line-height: 60px;
        font-size: 26px;
        right: 2px;
        bottom: 3px;
        &:hover{
            right: 0;
        }
    }
</style>
<style>
    >>>.el-progress /deep/ .el-progress-bar__outer {
        border-radius: 0;
        background: #fff;
    }
    >>>.el-progress /deep/ .el-progress-bar__inner {
        border-radius: 0;
    }
</style>
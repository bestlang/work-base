<template>
    <div>
        <el-card shadow="hover">
            <el-calendar @input="dateChange">
                <template
                        slot="dateCell"
                        slot-scope="{date, data}">
                    <p style="font-size: 18px;font-weight: 300;">
                        {{ data.day.split('-').slice(1).join('/') }}
                    </p>
                    <div v-show="showResult(data.day) && timeLine(data.day)">
                        <el-progress  :percentage="50"  :show-text="false" stroke-linecap="square" :stroke-width="4" color="#ddd"></el-progress>
                        <el-progress  style="margin-top: 2px" :percentage="timeLine(data.day) * 50"  :show-text="false" stroke-linecap="square" :stroke-width="4"></el-progress>
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
            <el-button @click="filterWeed">-周末</el-button>
            <el-button @click="plusWeed">+周末</el-button>
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
                        <span @click="viewUser(u.userid)" style="cursor:pointer;display: inline-block;margin-right: 20px;border-radius: 6px;padding: 5px 20px;background-color: #f1f1f1;border: 1px solid #e1e1e1" v-for="u in gu">
                            {{u.name}}
                            <!-- -{{u.userid}}-->
                        </span>
                    </p>
                </div>
            </div>
        </el-drawer>
    </div>
</template>
<script>
    import Vue from 'vue'
    import ECharts from 'vue-echarts' // refers to components/ECharts.vue in webpack

    // import ECharts modules manually to reduce bundle size
    import 'echarts/lib/chart/line'
    import 'echarts/lib/chart/bar'
    import 'echarts/lib/chart/scatter'
    import 'echarts/lib/component/tooltip'
    import 'echarts/lib/component/polar'
    import 'echarts/lib/component/angleAxis'

    // register component to use
    Vue.component('v-chart', ECharts)

    import api from "../../../../api/index"

    export default {
        data(){
            let onDuty =[]
            let offDuty = []
            let anyDate = '2020/9/28 00:00:00'
            return {
                drawer: false,
                direction: 'rtl',
                graph: true,

                userId: null,
                month: null,
                user: null,
                value : new Date(),
                attendances:{},
                users: [],
                groupedUser: {},
                options:{
                    grid:{
                        x:'2.2%',
                        y:'5%',
                        x2:'2.4%',
                        y2:'12%',
                        width: '100%'
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
                            params.forEach(function(item) {
                                let now = new Date(new Date(anyDate).getTime() + item.value[1])
                                let str = ''
                                let x =  now.getHours() + now.toLocaleTimeString().substr(-6,3)
                                str += '<span style="display:inline-block;margin-right:5px;border-radius:10px;width:9px;height:9px;background-color:' + item.color + '"></span>';
                                str += '<span style="font-size: 10px;">'+item.value[0] + item.seriesName + ":" + x + '</span>'
                                result.push(str)
                            });
                            return result.join('<br>')
                        }
                    },
                    series:[
                        {
                            name: '上班',
                            type: 'line',
                            showSymbol: true,
                            symbolSize:12,
                            stack: '上班',
                            data: onDuty,
                            dataBak: []
                        },
                        {
                            name: '下班',
                            type: 'line',
                            showSymbol: true,
                            symbolSize:12,
                            stack: '下班',
                            data: offDuty,
                            dataBak: []
                        },

                    ]
                }
            }
        },
        computed:{

        },
        watch:{
            async '$route'(to, from){
                if(to.path == '/sniper/employee/employee/attendance/detail'){
                    await this.getUser(to.query.userId)
                    await this.getUserAttendance(to.query.userId, this.month)
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
                    await this.getUser(val)
                }
            },
            async month(val){
                if(this.userId)
                    await this.getUserAttendance(this.userId, val)
            }
        },
        methods:{
            filterWeed(){
                console.log(this.options)
                if(!this.options.series[0].dataBak.length && !this.options.series[1].dataBak.length){
                    this.options.series[0].dataBak = JSON.parse(JSON.stringify(this.options.series[0].data))
                    this.options.series[1].dataBak = JSON.parse(JSON.stringify(this.options.series[1].data))
                }
                let ex = d => {
                    return d.value[0].indexOf('日') == -1 && d.value[0].indexOf('六') == -1
                }
                this.options.series[0].data = this.options.series[0].data.filter(ex)
                this.options.series[1].data = this.options.series[1].data.filter(ex)
            },
            plusWeed(){
                if(this.options.series[0].dataBak.length && this.options.series[1].dataBak.length){
                    this.options.series[0].data = this.options.series[0].dataBak
                    this.options.series[1].data = this.options.series[1].dataBak
                }
            },
            viewUser(userid){
                this.$router.push(`/sniper/employee/employee/attendance/detail?userId=${userid}&month=2020-09`)
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
                    onDutyTimeResult = '<span style="color: red;font-weight: 700">上班' + resultMap[onDutyTimeResult] + Math.floor((on.userCheckTime - on.baseCheckTime)/1000/60) + '分钟</span>'+onClock
                }else if(onDutyTimeResult == 'NotSigned'){
                    onDutyTimeResult = '<span style="color: orange;font-weight: 700">上班' + resultMap[onDutyTimeResult] + '</span>'+onClock
                }else if(onDutyTimeResult == 'Normal'){
                    onDutyTimeResult = '<span style="color: green;font-weight: 700">上班' + resultMap[onDutyTimeResult] + '</span>'+onClock
                }
                if(offDutyTimeResult == 'Early'){
                    let off = this.attendances[day].OffDuty
                    offDutyTimeResult = '<span style="color: red;font-weight: 700">下班' + resultMap[offDutyTimeResult] + Math.floor((off.baseCheckTime - off.userCheckTime)/1000/60) + '分钟</span>'+offClock
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
            async getUserAttendance(userId, month){
                let {data} = await api.sniperDingGetUsersAttendance({userIds:[userId], month})
                let values = Object.values(data)
                this.attendances = values[0]
                if(true){
                    let OnDuty = []
                    let OffDuty = []
                    for(let d in this.attendances){
                        let day = this.attendances[d]
                        day.OnDuty && OnDuty.push({
                                value: [day.OnDuty.ymd.slice(5).replace('-','/')+day.OnDuty.w, parseInt(day.OnDuty.userCheckTime) - new Date(`${day.OnDuty.ymd} 00:00:00`)]
                            })
                        day.OffDuty &&OffDuty.push({
                            value: [day.OffDuty.ymd.slice(5).replace('-', '/')+day.OffDuty.w, parseInt(day.OffDuty.userCheckTime) - new Date(`${day.OffDuty.ymd} 00:00:00`)]
                        })
                    }
                    this.options.series[0].data = OnDuty
                    this.options.series[1].data = OffDuty
                    this.options.series[0].dataBak = []
                    this.options.series[1].dataBak = []
                }
            },
            async getDepartmentUsers(){
                let res = await api.sniperDingGetDepartmentUsers()
                if(res && res.data){
                    this.users = res.data
                }
            }
        },
        async mounted(){

            let month = this.$route.query.month || null
            if(month){
                this.month = month
            }
            let userId = this.$route.query.userId || null
            if(userId){
                this.userId = userId
                await this.getUserAttendance(userId, this.month)
            }
            await this.getDepartmentUsers()
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
        right: -30px;
        bottom: 0;
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
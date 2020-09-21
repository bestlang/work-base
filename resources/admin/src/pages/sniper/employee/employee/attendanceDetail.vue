<template>
    <div>
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
        <div><i style="color: #555;">{{month}}月份</i></div>
        <div style="border-top: 1px solid #ccc;display: flex;flex-flow: row nowrap;justify-content: space-between" v-if="user">
            <!--{{user}}-->
            <div><b style="color: #555;">{{user.name}}</b><i style="color: #aaa;"><{{user.orgEmail}}></i> <span style="color: #fff;">{{user.userid}}</span></div>
            <div style="color: #555;font-style: italic">{{user.department_info?user.department_info.name:''}}</div>
        </div>
    </div>
</template>
<script>
    import api from "../../../../api/index"
    export default {
        data(){
            return {
                userId: null,
                month: null,
                user: null,
                value : new Date(),
                attendances:{}
            }
        },
        computed:{

        },
        watch:{
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
            format0(){
                return ''
            },
            format(percentage, e){
                console.log(e)
               return  'dasdas'//this.readable(day).offDutyTime
            },
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
                console.log(Object.values(data))
                this.attendances = Object.values(data)[0]
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

        }
    }
</script>
<style scoped>
    >>>.el-progress /deep/ .el-progress-bar__outer {
        border-radius: 0;
        background: #fff;
    }
    >>>.el-progress /deep/ .el-progress-bar__inner {
        border-radius: 0;
    }
</style>
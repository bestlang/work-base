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
                    <el-progress  :percentage="50" :show-text="false" stroke-linecap="square" :stroke-width="4" color="#ddd"></el-progress>
                    <el-progress style="margin-top: 2px" :percentage="timeLine(data.day) * 50" :show-text="false" stroke-linecap="square" :stroke-width="4" status="success"></el-progress>
                </div>
                <div v-show="showResult(data.day)" style="font-size: 12px;color: #5a5e66">
                    <p><span v-html="readable(data.day).onDutyTimeResult"></span></p>
                    <p><span v-html="readable(data.day).offDutyTimeResult"></span></p>
                </div>

            </template>
        </el-calendar>
        <div>
            {{month}}
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
                value : new Date(),
                attendances:{}
            }
        },
        computed:{

        },
        watch:{
            async userId(){

            },
            async month(val){
                if(this.userId)
                    await this.getUserAttendance(this.userId, val)
            }
        },
        methods:{
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
                if(this.attendances[day] && this.attendances[day].OnDuty){
                    onDutyTimeResult = this.attendances[day].OnDuty.timeResult
                }
                if(this.attendances[day] && this.attendances[day].OffDuty){
                    offDutyTimeResult = this.attendances[day].OffDuty.timeResult
                }
                if(onDutyTimeResult == 'Late'){
                    let on = this.attendances[day].OnDuty
                    onDutyTimeResult = '<span style="color: red;font-weight: 700">上班:' + resultMap[onDutyTimeResult] + Math.ceil((on.userCheckTime - on.baseCheckTime)/1000/60) + '分钟</span>'
                }else if(onDutyTimeResult == 'NotSigned'){
                    onDutyTimeResult = '<span style="color: orange;font-weight: 700">上班:' + resultMap[onDutyTimeResult] + '</span>'
                }else if(onDutyTimeResult == 'Normal'){
                    onDutyTimeResult = '<span style="color: green;font-weight: 700">上班:' + resultMap[onDutyTimeResult] + '</span>'
                }
                if(offDutyTimeResult == 'Early'){
                    let off = this.attendances[day].OffDuty
                    offDutyTimeResult = '<span style="color: red;font-weight: 700">下班:' + resultMap[offDutyTimeResult] + Math.ceil((off.baseCheckTime - off.userCheckTime)/1000/60) + '分钟</span>'
                }else if(offDutyTimeResult == 'NotSigned'){
                    offDutyTimeResult = '<span style="color: orange;font-weight: 700">下班:' + resultMap[offDutyTimeResult] + '</span>'
                }else if(offDutyTimeResult == 'Normal'){
                    offDutyTimeResult = '<span style="color: green;font-weight: 700">下班:' +resultMap[offDutyTimeResult] + '</span>'
                }

                return {
                    onDutyTimeResult,
                    offDutyTimeResult
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
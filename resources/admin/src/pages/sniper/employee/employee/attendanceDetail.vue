<template>
    <el-calendar @input="show">
        <template
                slot="dateCell"
                slot-scope="{date, data}">
            <p style="font-size: 18px;font-weight: 300;">
                {{ data.day.split('-').slice(1).join('/') }}
            </p>
            <div v-show="showResult(data.day)" style="font-size: 12px;color: #5a5e66">
                <p><span v-html="readable(data.day).onDutyTimeResult"></span></p>
                <p><span v-html="readable(data.day).offDutyTimeResult"></span></p>
            </div>
        </template>
    </el-calendar>
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

            }
        },
        methods:{
            show(row){
                console.log(JSON.stringify(row))
            },
            showResult(day){
                return day.split('-').slice(0, 2).join('-') == this.month
            },
            readable(day){
                const resultMap = {
                    '':'',
                    Normal: '正常',
                    Late: '迟到',
                    Early: '<span style="color: red">早退</span>',
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
                    onDutyTimeResult = '<span style="color: #761b18;font-weight: 700">上班:' + resultMap[onDutyTimeResult] + '</span>'
                }else if(onDutyTimeResult == 'Normal'){
                    onDutyTimeResult = '<span style="color: green;font-weight: 700">上班:' + resultMap[onDutyTimeResult] + '</span>'
                }
                if(offDutyTimeResult == 'Early'){
                    let off = this.attendances[day].OffDuty
                    offDutyTimeResult = '<span style="color: red;font-weight: 700">下班:' + resultMap[offDutyTimeResult] + Math.ceil((off.baseCheckTime - off.userCheckTime)/1000/60) + '分钟</span>'
                }else if(offDutyTimeResult == 'NotSigned'){
                    offDutyTimeResult = '<span style="color: #761b18;font-weight: 700">下班:' + resultMap[offDutyTimeResult] + '</span>'
                }else if(offDutyTimeResult == 'Normal'){
                    offDutyTimeResult = '<span style="color: green;font-weight: 700">下班:' +resultMap[offDutyTimeResult] + '</span>'
                }

                return {
                    onDutyTimeResult,
                    offDutyTimeResult
                }
            },
            async getUserAttendance(userId){
                let {data} = await api.sniperDingGetUsersAttendance({userIds:[userId]})
                console.log(Object.values(data))
                this.attendances = Object.values(data)[0]
            }
        },
        async mounted(){
            let userId = this.$route.query.userId || null
            let month = this.$route.query.month || null
            if(userId){
                this.userId = userId
                await this.getUserAttendance(userId)
            }
            if(month){
                this.month = month
            }
        }
    }
</script>
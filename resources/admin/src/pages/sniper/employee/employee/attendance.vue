<template>
    <div class="l-attendance-list">
        <div v-title="'考勤记录'"></div>
        <ding-department-tree class="l-tree"  @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded" :updated="updated"></ding-department-tree>
        <div class="l-block">
            <div class="l-block-header">
                {{department ? department.name : ''}}
            </div>
            <div class="l-block-body">
                    <div class="l-month-select">
                        <ul style="width: 50%; border-bottom: 1px solid #f1f1f1;padding-bottom: 10px;margin-bottom: 10px;">
                            <li style="border:none;cursor: default">月份</li>
                            <li v-for="m in months" @click="viewMonth" :class="{active: month == m}">{{m}}</li>
                        </ul>
                        <ul style="width: 50%">
                            <li style="border:none;cursor: default">分类</li>
                            <li v-for="ec in eventCats" @click="viewCat" :class="{active: eventCat == ec}">{{ec}}</li>
                        </ul>
                    </div>
                    <div class="l-user-wrap">
                            <div v-for="(user, index) in specUsers" :key="index" class="l-user" @click="viewDetail(user)">
                                <div v-if="!user.onJob" style="position: absolute;top:0;left:0;width: 100%;height: 100%;background: rgba(255,255,255,0.7);"></div>
                                <div style="border-bottom: 1px solid #f1f1f1;padding-bottom: 10px;">
                                <div><p>{{user.name}}</p><small style="color: #fff;display: none;">{{user.userid}}</small></div>
                                <div><small style="color: #afafaf">{{user.orgEmail ? user.orgEmail : '-'}}</small></div>
                                </div>
                                <div>
                                    <div v-if="user.result">
                                        <small><span style="font-weight: lighter" v-html="resultHtml(user)"></span>
                                            <!--<span v-if="user.leave && user.leave.length" :title="user.leaveStr"><small  style="color: darkorange;font-weight: normal;"><span class="iconfont">&#xe60b;</span>请假{{user.leave.length}}次</small></span>-->
                                        </small>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
        </div>

    </div>
</template>
<script>
    import api from "../../../../api/index"
    import DingDepartmentTree from "../components/DingDepartmentTree"
    import { Loading } from 'element-ui'

    export default {
        components:{
            DingDepartmentTree
        },
        data(){
            return {
                months:['2020-05', '2020-06', '2020-07', '2020-08', '2020-09', '2020-10'],
                month: '2020-10',
                eventCats: ['所有', '迟到', '请假', '缺卡', '早退'],
                eventCat: '所有',
                updated: 0,
                department: null,
                users: [],
                specUsers: [],
                lateUser: [],
                earlyUsers: [],
                holidayUsers: [],
                notSignedUsers: [],
            }
        },
        watch:{
            async ['department.id'](id){
                await this.getDepartmentUsers({id})
            },
            async month(val){
                await this.getDepartmentUsers(this.department)
                await this.getDepartmentWeekAvgAttendance()
            },
            eventCat(val){
                this.assignUsers(val)
            }
        },
        methods:{
            assignUsers(val){
                if(val == '迟到'){
                    this.specUsers = this.lateUsers
                }else if(val == '早退'){
                    this.specUsers = this.earlyUsers
                }else if(val == '请假'){
                    this.specUsers = this.holidayUsers
                }else if(val == '缺卡'){
                    this.specUsers = this.notSignedUsers
                }else{
                    this.specUsers = this.users
                }
            },
            viewMonth(el){
                this.month = el.target.innerText
            },
            viewCat(el){
                this.eventCat = el.target.innerText
            },
            resultHtml(user){
                let result = user.result
                let html = ''
                if(result.Late){
                    html += '<span style="color: #dd7777">'+'迟到'+result.Late+'次</span>'
                }
                if(result.Early){
                    html += '<span style="color: orange">'+'早退'+result.Early+'次</span>'
                }
                if(result.NotSigned){
                    html += '<span style="color: gray">'+'缺卡'+result.NotSigned+'次</span>'
                }
                if(user.leave && user.leave.length){
                    html += '<span title="'+user.leaveStr+'"><span  style="color: darkorange;font-weight: normal;"><span class="iconfont">&#xe60b;</span>请假'+user.leave.length+'次</span></span>'
                }
                if(!html){
                    html = '<span style="color: green">正常</span>'
                }
                return html
            },
            viewDetail(user){
                let userId = user.userid
                let str
                if(!this.month){
                    let d = new Date()
                    let str = d.getFullYear()
                    let m = d.getMonth() + 1
                    if(m < 10){
                        m = '0'+m
                    }
                    str += '-' + m
                }else{
                    str = this.month
                }
                //+`&month=`+str
                this.$router.push(`/sniper/employee/employee/attendance/detail?userId=`+user.userid)
            },
            handleNodeClick(node){
                this.department = node
                //console.log('node click:'+JSON.stringify(node))
            },
            performTreeLoaded(department){
                this.department = department
            },
            async getDepartmentUsers({id}){
                let startLoad = Loading.service({ fullscreen: true, text: '获取中...', background: 'rgba(255,255,255,0.8)' })
                let res = await api.sniperDingGetDepartmentUsers({id})
                let userIds = res.data.map(function(user){
                    return user.userid
                })
                this.users = res.data
                await this.getUsersAttendance({userIds})
                startLoad.close()

            },
            async getUsersAttendance({userIds}){
                let month = this.month
                let {data} = await api.sniperDingGetUsersAttendance({userIds, month})
                let lastArr = {}
                for(let userId in data){

                    for(let dt in data[userId]){
                        if(!lastArr[userId]){
                            lastArr[userId] = {}
                        }
                        //tp == type
                        for(let tp in data[userId][dt]){

                            if(!lastArr[userId][data[userId][dt][tp].timeResult]){
                                lastArr[userId][data[userId][dt][tp].timeResult] = 0
                            }
                            if(!data[userId][dt][tp].approveId && !data[userId][dt][tp].procInstId){
                                lastArr[userId][data[userId][dt][tp].timeResult] += 1
                            }
                        }
                    }
                }
                for(let userId in lastArr){
                    for(let idx in this.users){
                        if(this.users[idx].userid == userId) {
                            this.$set(this.users[idx], 'result', lastArr[userId])
                            this.$set(this.users[idx], 'leave', data[userId].leave)
                            let leaveStr = ''
                            for(let id in data[userId].leave){
                                leaveStr += '['+data[userId].leave[id].start_time+'~'+data[userId].leave[id].end_time+'],'
                            }

                            this.$set(this.users[idx], 'leaveStr', leaveStr.slice(0,-1))
                        }
                    }
                }
                this.lateUsers = this.users.filter((user) => {
                    return user.result && user.result.Late
                }).sort((a, b) => {
                    return b.result.Late - a.result.Late
                })
                this.earlyUsers = this.users.filter((user) => {
                    return user.result && user.result.Early
                }).sort((a, b) => {
                    return b.result.Early - a.result.Early
                })
                this.holidayUsers = this.users.filter((user) => {
                    return user.leave && user.leave.length
                }).sort((a, b) => {
                    return b.leave.length - a.leave.length
                })
                this.notSignedUsers = this.users.filter((user) => {
                    return user.result && user.result.NotSigned
                }).sort((a, b) => {
                    return b.result.NotSigned - a.result.NotSigned
                })
                this.assignUsers(this.eventCat)
                //console.log("lastArr:"+JSON.stringify(lateUsers))
            },
        }
    }
</script>
<style scoped lang="less">
    .l-attendance-list{
        display: flex;
        flex-flow: row nowrap;
        min-height: calc(100vh - 50px - 20px);
        margin:-20px 0 -20px -20px;
        overflow-x: hidden;
        .l-tree{
            width: 280px;
            padding: 10px 20px;
            border-right: 1px solid #f4f4f4;
            flex-shrink: 0;
            overflow-y: auto;
        }
        .l-tree-content{
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-flow: row nowrap;
            box-sizing: border-box;
            width: 1800px;
            flex-shrink: 20;
        }
    }
    .l-block{
        padding-left: 20px;
        .l-block-body{
            .l-month-select{
                border-bottom: 1px solid #f1f1f1;
                padding-bottom: 10px;
                margin-bottom: 10px;
                ul{
                    display: flex;
                    flex-flow: row nowrap;
                    justify-content: flex-start;
                    li{
                        float: left;
                        cursor: pointer;
                        border: 1px solid #eee;
                        border-radius: 3px;
                        padding: 3px 8px;
                        margin-right: 10px;
                        &.active{
                            color: #fff;
                            border-color: #293c55;
                            background-color: #293c55;
                        }
                    }
                }
            }
            .l-user-wrap{
                display: flex;
                flex-flow: row wrap;
                justify-content: flex-start;
                .l-user{
                    position: relative;
                    cursor: pointer;
                    width: 220px;
                    height: 140px;
                    border: 1px solid #f1f1f1;
                    margin-bottom: 20px;
                    margin-right: 20px;
                    display: flex;
                    flex-flow: column;
                    justify-content: space-between;
                    padding: 15px 10px 10px;
                    background: #F2F8FE;
                    &:hover{
                        box-shadow: 3px 3px 6px #f1f1f1;
                        background: #fcf8e3;
                    }
                }
            }
        }
    }
    @media screen and (max-width: 1500px) {
        .l-block{
            .l-block-body{
                .l-user-wrap{
                    .l-user{
                        width: 200px;
                        height: 120px;
                    }
                }
            }
        }
    }
</style>
<template>
    <div class="l-attendance-list">
        <div v-title="'考勤记录'"></div>
        <ding-department-tree class="l-tree"  @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded" :updated="updated"></ding-department-tree>
        <div class="l-block">
            <div class="l-block-header">
                {{department ? department.name : ''}}
            </div>
            <div class="l-block-body">
                    <div class="l-user-wrap">
                            <div v-for="(user, index) in users" :key="index" class="l-user" @click="viewDetail(user)">
                                <div style="border-bottom: 1px solid #f1f1f1;padding-bottom: 10px;">
                                <div><p>{{user.name}}</p><small style="color: #fff;display: none;">{{user.userid}}</small></div>
                                <div><small style="color: #afafaf">{{user.orgEmail ? user.orgEmail : '-'}}</small></div>
                                </div>
                                <!--<div><small>本周：正常1次 迟到1次 早退1次</small></div>-->
                                <div>
                                    <div v-if="user.result">
                                        <small>本月：
                                            <span style="font-weight: lighter" v-html="resultHtml(user.result)"></span>
                                            <span v-if="user.leave && user.leave.length" :title="user.leaveStr"><small  style="color: darkorange;font-weight: normal;"><span class="iconfont">&#xe60b;</span>请假{{user.leave.length}}次</small></span>
                                        </small>
                                    </div>
                                </div>
                                <!--<div><small>{{user.result}}</small></div>-->
                                <div></div>
                            </div>
                    </div>
            </div>
        </div>

    </div>
</template>
<script>
    import api from "../../../../api/index"
    import DingDepartmentTree from "../components/DingDepartmentTree"
    export default {
        components:{
            DingDepartmentTree
        },
        data(){
            return {
                updated: 0,
                department: null,
                users: []
            }
        },
        watch:{
            async ['department.id'](id){
                await this.getDepartmentUsers({id})
            }
        },
        methods:{
            resultHtml(result){
                let html = ''
                if(result.Late){
                    html += '<span style="color: red">'+'迟到'+result.Late+'次</span>'
                }
                if(result.Early){
                    html += '<span style="color: orange">'+'早退'+result.Early+'次</span>'
                }
                if(result.NotSigned){
                    html += '<span style="color: gray">'+'未打卡'+result.NotSigned+'次</span>'
                }
                if(!html){
                    html = '<span style="color: green">正常</span>'
                }
                return html
            },
            viewDetail(user){
                let userId = user.userid
                this.$router.push('/sniper/employee/employee/attendance/detail?userId='+user.userid+'&month=2020-09')
            },
            handleNodeClick(node){
                this.department = node
                // this.assignForm(node)
                console.log('node click:'+JSON.stringify(node))
            },
            performTreeLoaded(department){
                console.log('performTreeLoaded:'+JSON.stringify(department))
                this.department = department
                // this.assignForm(department)
            },
            async getDepartmentUsers({id}){
                let res = await api.sniperDingGetDepartmentUsers({id})
                let userIds = res.data.map(function(user){
                    return user.userid
                })
                this.users = res.data
                await this.getUsersAttendance({userIds})

            },
            async getUsersAttendance({userIds}){
                let {data} = await api.sniperDingGetUsersAttendance({userIds})
                let lastArr = {};
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
                                lastArr[userId][data[userId][dt][tp].timeResult] +=1
                            }
                        }
                    }
                }
                for(let userId in lastArr){
                    console.log(userId, "\n")
                    for(let idx in this.users){
                        if(this.users[idx].userid == userId) {
                            this.$set(this.users[idx], 'result', lastArr[userId])
                            this.$set(this.users[idx], 'leave', data[userId].leave)
                            let leaveStr = ''
                            for(let id in data[userId].leave){
                                leaveStr += '['+data[userId].leave[id].start_time+'~'+data[userId].leave[id].end_time+'],';
                            }

                            this.$set(this.users[idx], 'leaveStr', leaveStr.slice(0,-1))
                        }
                    }
                }
                console.log("lastArr:"+JSON.stringify(lastArr));
            }
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
            .l-user-wrap{
                display: flex;
                flex-flow: row wrap;
                justify-content: flex-start;
                .l-user{
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
</style>
<template>
    <div class="l-position-list">
        <div v-title="'考勤记录'"></div>
        <ding-department-tree  @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded" :updated="updated"></ding-department-tree>
        <div class="l-block">
            <div class="l-block-header">
                考勤人员
            </div>
            <div class="l-block-body">
                    <div class="l-user-wrap">
                            <div v-for="(user, index) in users" :key="index" class="l-user">
                                <div style="border-bottom: 1px solid #f1f1f1;padding-bottom: 10px;">
                                <div><b>{{user.name}}</b><span style="color: #fff">{{user.userid}}</span></div>
                                <div><small style="color: #afafaf">{{user.orgEmail ? user.orgEmail : '-'}}</small></div>
                                </div>
                                <!--<div><small>本周：正常1次 迟到1次 早退1次</small></div>-->
                                <div>
                                    <div v-if="user.result">
                                        <small>本月：
                                    {{user.result.Late?'迟到'+user.result.Late+'次':''}}
                                    {{user.result.Early?'早退'+user.result.Early+'次':''}}
                                        </small>
                                </div>
                                </div>
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
                    //console.log(userId+':')
                    for(let dt in data[userId]){
                        if(!lastArr[userId]){
                            lastArr[userId] = {}
                        }
                        //console.log("\t"+dt+':')
                        for(let tp in data[userId][dt]){
                            //console.log("\t\t" + tp + ":")
                            //console.log("\t\t\t"+data[userId][dt][tp].timeResult)
                            if(!lastArr[userId][data[userId][dt][tp].timeResult]){
                                lastArr[userId][data[userId][dt][tp].timeResult] = 0
                            }
                            lastArr[userId][data[userId][dt][tp].timeResult] +=1
                        }
                    }
                }
                for(let userId in lastArr){
                    console.log(userId, "\n")
                    for(let idx in this.users){
                        if(this.users[idx].userid == userId) {
                            this.$set(this.users[idx], 'result', lastArr[userId])
                        }
                    }
                }
                console.log("lastArr:"+JSON.stringify(lastArr));
            }
        }
    }
</script>
<style scoped lang="less">
    .l-user-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-user{
            width: 240px;
            height: 120px;
            border: 1px solid #f1f1f1;
            margin-bottom: 20px;
            margin-right: 20px;
            display: flex;
            flex-flow: column;
            justify-content: space-between;
            padding: 15px 10px 10px;

        }
    }
    .l-position-list{
        display: flex;
        flex-flow: row nowrap;
        min-height: calc(100vh - 50px - 20px);
        margin:-20px 0 -20px -20px;
        overflow-x: hidden;
        .l-tree-container{
            min-width: 200px;
            padding: 20px;
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
            width: calc(100% - 240px);
        }
    }
    .l-block{
        padding-left: 20px;
    }
    .l-department-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-department{
            position: relative;
            box-shadow: #67C23A;
            height: 140px;
            border:1px solid #f1f1f1;
            width: 220px;
            margin: 20px 30px 0 0;
            border-radius: 2px;
            cursor: pointer;
            background: #F2F8FE;
            &:hover{
                box-shadow: 3px 3px 6px #FAFAFA;
                background: #fcf8e3;
                h1{
                    color: #2d2d2d;
                }
            }
            h1{
                font-size: 16px;
                color: #777;
                padding: 10px 0 0 10px;
                font-weight: bold;
            }
            .l-employee-count{
                color: #4c110f;
                position: absolute;
                bottom: 10px;
                left: 10px;
                font-size: 14px;
            }
        }
    }
</style>
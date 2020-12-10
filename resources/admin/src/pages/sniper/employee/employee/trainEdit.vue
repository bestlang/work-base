<template>
    <div>
        <div v-title="'新增/编辑培训'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <span>新增培训记录</span>
                    <el-button size="small" type="primary" @click="handleSave"><i class="if">&#xe9d3;</i> 保存</el-button>
                </div>
            </div>
            <div class="l-block-body">
                <el-tabs type="border-card" v-model="activeName">
                    <el-tab-pane label="课程信息" name="lesson">
                        <el-form ref="form" :model="form" label-width="80px" size="small">
                            <el-form-item label="课程名称">
                                <el-input v-model="form.title"></el-input>
                            </el-form-item>
                            <el-form-item label="课程内容">
                                <el-input v-model="form.content"></el-input>
                            </el-form-item>
                            <el-form-item label="开始日期">
                                <el-date-picker
                                        v-model="form.start_time"
                                        type="datetime"
                                        placeholder="选择开始日期"
                                        align="right"
                                        :picker-options="pickerOptions">
                                </el-date-picker>
                            </el-form-item>
                            <el-form-item label="结束日期">
                                <el-date-picker
                                        v-model="form.end_time"
                                        type="datetime"
                                        placeholder="选择结束日期"
                                        align="right"
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
                    <el-tab-pane label="参会人员" name="member">
                        <div>
                            <el-button type="primary" icon="el-icon-plus" size="small" circle style="margin-bottom: 10px;" @click="handleAddParticipant"></el-button>
                        </div>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </div>
</template>
<script>
    import api from 'sysApi'
    import {formatDateTime} from "sysApi/util"

    export default {
        name: 'sniperEmployeeTrainEdit',
        data(){
            return {
                activeName: 'lesson',
                keyword: '',
                form:{
                        title: '',
                        content: '',
                        start_time: null,
                        end_time: null,
                        last_days: 0,
                        last_hours: 0,
                        last_minutes: 0,
                        teacher: '',
                        location: '',
                        participants:[
                            // {name: '路章<luzhang@sniper-tech.com>', department: '软件组'},
                            // {name: '路章<luzhang@sniper-tech.com>', department: '软件组'}
                        ]
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
            handleSearch(){},
            handleAdd(){},
            handleSave(){
                alert(JSON.stringify(this.form))
            },
            handleAddParticipant(){}
        },
        watch:{
            ['form.start_time'](val){
                if(val){
                    if(!/\d{4}\-\d{2}\-\d{2}/.test(val)){
                        this.form.start_time = formatDateTime(val)
                    }
                }
            },
            ['form.end_time'](val){
                if(val){
                    if(!/\d{4}\-\d{2}\-\d{2}/.test(val)){
                        this.form.end_time = formatDateTime(val)
                    }
                }
            }
        },
        components: {},
        async mounted() {

        }
    }
</script>
<style scoped>
/deep/ .el-form--inline .el-form-item{
    margin-bottom: 0;
}
</style>
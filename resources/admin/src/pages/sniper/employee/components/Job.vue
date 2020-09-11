<template>
    <el-card class="box-card" shadow="hover">
        <el-form :model="form" label-width="80px">
            <el-form-item label="起止日期">
                <el-date-picker
                        :editable="false"
                        v-model="form.start_time"
                        type="month"
                        value-format="yyyy-MM"
                        placeholder="开始日期">
                </el-date-picker>
                ~
                <el-date-picker
                        :editable="false"
                        v-model="form.end_time"
                        type="month"
                        value-format="yyyy-MM"
                        placeholder="结束日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="企业名称">
                <el-input v-model="form.company"></el-input>
            </el-form-item>
            <el-form-item label="岗位">
                <el-input v-model="form.position"></el-input>
            </el-form-item>
            <el-form-item label="薪酬">
                <el-input v-model="form.salary"></el-input>
            </el-form-item>
            <el-form-item label="离职原因">
                <el-input type="text" v-model="form.reason"></el-input>
            </el-form-item>
            <el-form-item label="证明人电话">
                <el-input type="text" v-model="form.witness_phone"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submit">确定</el-button>
                <el-button type="warning" @click="cancel">取消</el-button>
            </el-form-item>
        </el-form>
    </el-card>
</template>
<script>
    export default {
        props:{
            defaultData:{
                type: Object,
                default: null
            },
            pageSize: {
                type: Number,
                default: 15
            }
        },
        watch:{
            defaultData: {
                deep: true,
                handler: function(data){
                    this.assignForm(data)
                }
            }
        },
        data(){
            return {
                form:{
                    id: null,
                    start_time: null,
                    end_time: null,
                    company: null,
                    position: null,
                    salary: 0,
                    reason: '',
                    witness_phone: ''
                }
            }
        },
        methods:{
            assignForm(data){
                this.form.id = data.id || null
                this.form.start_time = data.start_time
                this.form.end_time = data.end_time
                this.form.company = data.company
                this.form.position = data.position
                this.form.salary = data.salary
                this.form.reason = data.reason
                this.form.witness_phone = data.witness_phone
            },
            cancel(){
                this.$emit('cancel')
            },
            submit(){
                this.$emit('submit', this.form)
            }
        },
        mounted(){}
    }
</script>
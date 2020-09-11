<template>
    <el-card class="box-card" shadow="hover">
        <el-form :model="form" label-width="80px">
            <el-form-item label="起止年月">
                <el-date-picker
                        :editable="false"
                        v-model="form.start_time"
                        type="month"
                        placeholder="开始年月">
                </el-date-picker>
                 ~
                <el-date-picker
                        :editable="false"
                        v-model="form.end_time"
                        type="month"
                        placeholder="结束年月">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="学校名称">
                <el-input v-model="form.school"></el-input>
            </el-form-item>
            <el-form-item label="专业">
                <el-input v-model="form.specialize"></el-input>
            </el-form-item>
            <el-form-item label="学位">
                <el-input v-model="form.degree"></el-input>
            </el-form-item>
            <el-form-item label="是否统招">
                <div>
                    <el-radio v-model="form.unified" :label="1" border>是</el-radio>
                    <el-radio v-model="form.unified" :label="0" border>否</el-radio>
                </div>
            </el-form-item>
            <el-form-item>
                <el-button type="primary">确定</el-button>
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
                    school: null,
                    specialize: null,
                    degree: null,
                    unified: 1
                }
            }
        },
        methods:{
            assignForm(data){
                this.form.id = data.id || null
                this.form.start_time = data.start_time
                this.form.end_time = data.end_time
                this.form.school = data.school
                this.form.specialize = data.specialize
                this.form.degree = data.degree
                this.form.unified = data.unified
            },
            cancel(){
                this.$emit('cancel')
            }
        },
        mounted(){}
    }
</script>
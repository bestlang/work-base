<template>
    <el-card class="box-card" shadow="hover">
        <el-form size="small" :model="form" label-width="120px">
            <el-form-item label="起止日期*">
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
            <el-form-item label="学校名称*">
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
            <el-form-item label="毕业类型">
                <div>
                    <el-radio v-model="form.graduateType" :label="1" border>毕业</el-radio>
                    <el-radio v-model="form.graduateType" :label="2" border>肄业</el-radio>
                </div>
            </el-form-item>
            <el-form-item label="是否最高学历">
                <div>
                    <el-radio v-model="form.isHigh" :label="1" border>是</el-radio>
                    <el-radio v-model="form.isHigh" :label="0" border>否</el-radio>
                </div>
            </el-form-item>
            <el-form-item label="是否第一学历">
                <div>
                    <el-radio v-model="form.isFirst" :label="1" border>是</el-radio>
                    <el-radio v-model="form.isFirst" :label="0" border>否</el-radio>
                </div>
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
                    school: null,
                    specialize: null,
                    degree: null,
                    unified: 1,
                    graduateType: 1,
                    isHigh: 0,
                    isFirst: 0
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
                this.form.graduateType = data.graduateType
                this.form.isHigh = data.isHigh
                this.form.isFirst = data.isFirst
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
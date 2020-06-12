<template>
    <div class="add-row-tag">
        <el-row :gutter="0" v-for="(row, index) in rowData" :key="index" class="row-item">
            <el-col :span="7">
                <!--<label>标签:</label>-->
                <el-input
                        class="row-ipt"
                        placeholder="请输入标签"
                        v-model="row.name">
                </el-input>
            </el-col>
            <el-col :span="3" style="margin-top: 5px;">
                <i v-if="(index+1) == 1" class="add-icon el-icon-circle-plus" @click="addRow(row)"></i>
                <i v-else class="add-icon el-icon-remove" @click="deleteRow(row)"></i>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    export default {
        name: 'tag',
        props: {
            propData: {
                type: Array,
                required: false,
                default:function(){
                    return [{
                        id: 0,
                        name: ''
                    }]
                }
            }
        },
        data () {
            return {
                rowData: [{
                        id: 0,
                        name: ''
                    }]
            }
        },
        watch: {
            'rowData': {
                deep: true,
                handler(val){
                    this.$emit('tagChange', val)
                }
            }
        },
        methods: {
            addRow (row) {
                for(let idx in this.rowData){
                    this.rowData[idx].id == idx
                }
                let obj = {
                    id: this.rowData.length,
                    name: ''
                }
                this.rowData.push(obj)
            },
            deleteRow (row) {
                for(let idx in this.rowData){
                    if(this.rowData[idx].id == row.id){
                        this.$delete(this.rowData, idx)
                        break;
                    }
                }
            }
        },
        created() {
            if (this.propData.length > 0) {
                for(let idx in this.propData){
                    this.propData[idx]['id'] = parseInt(idx)
                }
                this.rowData = this.propData;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .add-row-tag {
        color: #5a5e66;
        font-size: 14px;
        .row-item {
            margin-bottom: 20px;
        }
        .el-col-7 {
            width: inherit;
        }
        .el-col {
            .row-ipt {
                width: inherit;
                width: 100px;
                font-size: 12px;
                margin-right: 5px;
            }
            .add-icon {
                color: #2da3fb;
                font-size: 30px;
            }
        }
        /*.el-col:first-child:before {*/
            /*content: "*";*/
            /*color: #f56c6c;*/
            /*margin-right: 4px;*/
        /*}*/
    }
</style>

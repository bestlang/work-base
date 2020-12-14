<template>
    <div>
        <div v-title="'培训管理'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <el-form ref="form"  :inline="true" size="small">
                        <el-form-item label="培训主题">
                            <el-input v-model="keyword" style="width: 200px;"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="default" @click="handleSearch"><i class="if">&#xe604;</i> 搜索</el-button>
                        </el-form-item>
                    </el-form>
                    <el-form size="small">
                        <el-form-item>
                            <el-button type="primary" size="small" @click="handleAdd"><i class="if">&#xe663;</i> 新增</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
            <div class="l-block-body">
                <el-table
                        :data="histories"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="ID"
                            width="80">
                    </el-table-column>
                    <el-table-column
                            prop="title"
                            label="标题">
                    </el-table-column>
                    <el-table-column
                            prop="content"
                            label="内容">
                    </el-table-column>
                    <el-table-column
                            prop="start_time"
                            label="开始时间">
                    </el-table-column>
                    <el-table-column
                            prop="end_time"
                            label="结束时间">
                    </el-table-column>
                    <el-table-column
                            prop="last_days"
                            label="持续时间(天)">
                    </el-table-column>
                    <el-table-column
                            prop="last_hours"
                            label="持续时间(时)">
                    </el-table-column>
                    <el-table-column
                            prop="last_minutes"
                            label="持续时间(分)">
                    </el-table-column>
                    <el-table-column
                            prop="teacher"
                            label="讲师">
                    </el-table-column>
                    <el-table-column
                            prop="location"
                            label="地点">
                    </el-table-column>
                    <el-table-column
                            width="180"
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="primary" @click="editTrain(scope.row)" size="mini">编辑</el-button>
                            <el-button type="danger" @click="deleteTrain(scope.row)" size="mini">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <pager :total="total" :page-size="page_size" @current-change="currentChange"></pager>
            </div>
        </div>
    </div>
</template>
<script>
    import api from 'sysApi'
    import {formatDateTime} from "sysApi/util"
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    import pager from "@/components/pager"

    const removeEmptyChildren = function(data){
        if(!data.children.length){
            data.children = undefined
        }else{
            for(let child of data.children){
                removeEmptyChildren(child)
            }
        }
    }

    export default {
        name: 'sniperEmployeeTrain',
        data(){
            return {
                total: 0,
                page_size: 10,
                keyword: '',
                histories: []
            }
        },
        methods:{
            editTrain(){},
            deleteTrain(){},
            currentChange(){},
            handleSearch(){},
            handleAdd(){
                this.$router.push('/train/edit')
            },
            async getHistories(){
                let {data} = await api.sniperEmployeeTrainHistories()
                this.histories = data.histories
                this.total = data.total
                this.page_size = data.page_size
            }
        },
        watch:{

        },
        components: {pager},
        async mounted() {
            await this.getHistories()
        }
    }
</script>
<style lang="less">

</style>
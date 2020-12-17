<template>
    <div>
        <div v-title="'公告管理'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <el-form ref="form"  :inline="true" size="small">
                        <el-form-item label="公告主题">
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
                            width="50">
                    </el-table-column>
                    <el-table-column
                            prop="title"
                            label="公告主题">
                    </el-table-column>
                    <el-table-column
                            prop="content"
                            label="公告内容">
                    </el-table-column>
                    <el-table-column
                            prop="publish_time"
                            label="发送时间">
                    </el-table-column>
                    <el-table-column
                            prop="user.name"
                            label="发布者">
                    </el-table-column>
                    <el-table-column
                            prop="note"
                            label="备注">
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
                page: 1,
                page_size: 10,
                keyword: '',
                histories: []
            }
        },
        methods:{
            editTrain({id}){
                this.$router.push('/train/edit?id='+id)
            },
            deleteTrain({id}){
                this.$confirm('确定删除培训记录?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.sniperDeleteEmployeeTrain({id})
                    if(!res.hasError){
                        this.$message.success('删除成功')
                    }
                    await this.getHistories()
                });
            },
            currentChange(page){
                this.page = page
                this.getHistories()
            },
            handleSearch(){
                this.page = 1
                this.getHistories()
            },
            handleAdd(){
                this.$router.push('/train/edit')
            },
            async getHistories(){
                let page = this.page;
                let page_size = this.page_size;
                let keyword = this.keyword;
                let {data} = await api.sniperEmployeeTrainHistories({page, page_size, keyword})
                this.histories = data.histories
                this.total = parseInt(data.total)
                this.page_size = parseInt(data.page_size)
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
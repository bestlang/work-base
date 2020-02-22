<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    <router-link class="l-cursor" to="/cms/position/position" tag="span"><span class="iconfont">&#xe601;</span> 返回</router-link>
                    <el-divider direction="vertical"></el-divider>
                    <span>「{{currentPosition.name}}」内容管理</span>
                </div>
                <!--<el-button type="primary" size="small" @click="handleAdd">新增</el-button>-->
            </div>
            <div class="l-block-body">
                <el-table
                        :data="tableData"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="ID"
                            width="180">
                    </el-table-column>
                    <!--<el-table-column-->
                            <!--prop="name"-->
                            <!--label="名称">-->
                    <!--</el-table-column>-->
                    <!--<el-table-column-->
                            <!--label="分类">-->
                        <!--<template slot-scope="scope">-->
                            <!--<span v-if="scope.row.is_channel" class="l-channel-color">栏目</span>-->
                            <!--<span v-else>内容</span>-->
                        <!--</template>-->
                    <!--</el-table-column>-->
                    <!--<el-table-column-->
                            <!--label="操作">-->
                        <!--<template slot-scope="scope">-->
                            <!--&lt;!&ndash;<el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>&ndash;&gt;-->
                        <!--</template>-->
                    <!--</el-table-column>-->
                </el-table>
            </div>
            <div class="l-block-bottom"></div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                tableData: []
            }
        },
        computed:{
            currentPosition(){
                return this.$store.getters.currentPosition
            }
        },
        methods:{
            loadContents(){
                this.$http
                    .get("/admin/cms/position/contents", {params: {id: this.currentPosition.id}})
                    .then(res => {
                        this.tableData = res.data;
                    });
            }
        },
        mounted(){
            this.loadContents()
        }
    }
</script>
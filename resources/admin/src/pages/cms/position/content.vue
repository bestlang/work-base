<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    <router-link class="l-cursor" to="/cms/position/position" tag="span"><span class="iconfont">&#xe601;</span> 返回</router-link>
                    <el-divider direction="vertical"></el-divider>
                    <span>推荐位「{{currentPosition.name}}」下属内容</span>
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
                    <el-table-column
                            prop="title"
                            label="标题">
                    </el-table-column>
                    <el-table-column
                            prop="channel.name"
                            label="栏目">
                    </el-table-column>
                    <el-table-column
                            prop="position.name"
                            label="推荐位">
                    </el-table-column>
                    <el-table-column
                            prop="pivot.order_factor"
                            label="排序值">
                    </el-table-column>
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
    import api from '../../../api/index'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                tableData: []
            }
        },
        computed:{
            ...mapGetters(['currentPosition']),
        },
        methods:{
            async loadContents(){
                let res = await api.getPositionContents({id: this.currentPosition.id})
                this.tableData = res.data;
            }
        },
        async mounted(){
            console.log(`current meta:`,this.$route.meta)
            await this.loadContents()
        }
    }
</script>
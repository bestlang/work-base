<template>
    <div>
        <div v-title="'广告管理'"></div>
        <div class="l-top-menu">
            <div>
                <el-button type="primary" @click="add" size="small">新增</el-button>
                <el-button type="primary" @click="positions" size="small">广告位</el-button>
            </div>
            <div></div>
        </div>
        <el-table
                v-loading="loading"
                :data="tableData"
                style="width: 100%">
            <el-table-column
                    prop="id"
                    label="ID"
                    width="100">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="名称">
            </el-table-column>
            <el-table-column
                    label="状态">
                <template slot-scope="scope">
                    {{scope.row.enabled == 1 ? '已启用' : '未启用'}}
                </template>
            </el-table-column>
            <el-table-column
                    label="广告位">
                <template slot-scope="scope">
                    {{scope.row.position.name}}
                </template>
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
                    label="操作">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <!--<el-dialog title="添加类型" :visible.sync="formVisible" :close-on-click-modal="false">-->
            <!--<el-form :model="form">-->
                <!--<el-form-item label="名称" :label-width="w">-->
                    <!--<el-input v-model="form.name" autocomplete="off"></el-input>-->
                <!--</el-form-item>-->
                <!--<el-form-item label="字段" :label-width="w">-->
                    <!--<el-input v-model="form.type" autocomplete="off"></el-input>-->
                <!--</el-form-item>-->
                <!--<el-form-item label="带选项" :label-width="w">-->
                    <!--<el-radio v-model="form.extra.options" :label="false">否</el-radio>-->
                    <!--<el-radio v-model="form.extra.options" :label="true">是</el-radio>-->
                <!--</el-form-item>-->
            <!--</el-form>-->
            <!--<div slot="footer" class="dialog-footer">-->
                <!--<el-button @click="formVisible = false">取 消</el-button>-->
                <!--<el-button type="primary" @click="submit">确 定</el-button>-->
            <!--</div>-->
        <!--</el-dialog>-->
    </div>
</template>

<script>
    import api from 'sysApi'
    export default {
        name: 'cmsOperationAds',
        data(){
            return {
                w: '80px',
                loading: true,
                tableData: [],
            }
        },
        methods:{
            handleEdit(row){
                this.$router.push('/cms/operation/edit/ad?id='+row.id)
            },
            handleDelete(row){
                this.$confirm('确认删除该广告?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.deleteAd({id: row.id})
                    if(res.success){
                        this.$message.success('操作成功');
                        await this.loadAds()
                    }
                })
            },
            add(){
                this.$router.push('/cms/operation/edit/ad');
            },
            positions(){
                this.$router.push('/cms/operation/ad/positions')
            },
            async submit(){
                let res = await api.saveModelFieldType(this.form)
                if(res.success) {
                    this.loading = true;
                    this.loadAds();
                    this.formVisible = false;
                    let successMsg = '添加成功!';
                    if(this.form.id){
                        successMsg = '编辑成功!';
                    }
                    this.$message.success(successMsg);
                }else{
                    this.$message.warning(res.error);
                }
            },
            async loadAds(){
                let res = await api.getAds()
                this.loading = false;
                this.tableData = res.data;
            }
        },
        async created() {
            await this.loadAds();
        }
    }
</script>
<style lang="less" scoped>
    .l-top-menu {
        display: flex;
        flex-flow: row nowrap;
        justify-content: space-between;
    }
</style>

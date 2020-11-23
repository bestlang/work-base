<template>
    <div>
        <div v-title="'广告位'"></div>
        <div class="l-top-menu">
            <div>
                <el-button type="primary" @click="add" size="small">新增</el-button>
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
                    {{scope.row.enabled?'已启用':'未启用'}}
                </template>
            </el-table-column>
            <el-table-column
                    label="操作">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="handleEdit(scope.row)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="handleDelete(scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="新增广告位" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form">
                <el-form-item label="名称" :label-width="w">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="启用" :label-width="w">
                    <el-radio-group v-model="form.enabled">
                        <el-radio :label="1">是</el-radio>
                        <el-radio :label="0">否</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="描述" :label-width="w">
                    <el-input type="textarea" v-model="form.description"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false">取 消</el-button>
                <el-button type="primary" @click="submit">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import api from 'sysApi'
    export default {
        name: 'cmsOperationAdPositions',
        data(){
            return {
                w: '80px',
                loading: true,
                tableData: [],
                formVisible: false,
                form: {
                    id: '',
                    name: '',
                    enabled: 1,
                    description: ''
                },
            }
        },
        methods:{
            handleEdit(row){
                this.formVisible = true;
                Object.assign(this.form, row);
            },
            async handleDelete(row){
                this.$confirm('确认删除该广告位?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.deleteAdPosition({id: row.id});
                    if(res.success){
                        this.$message.success('删除成功');
                    }else{
                        this.$message.error(res.error);
                    }
                    this.$message.success(JSON.stringify(res));
                    this.getAdPositions();
                })
            },
            add(){
                this.formVisible = true;
                Object.assign(this.form, {
                    id: '',
                    name: '',
                    enabled: 1,
                    description: ''
                })
            },
            async submit(){
                let res = await api.saveAdPosition(this.form)
                if(res.success) {
                    this.loading = true;
                    this.getAdPositions();
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
            async getAdPositions(){
                let res = await api.getAdPositions()
                this.loading = false;
                this.tableData = res.data;
            }
        },
        async created() {
            await this.getAdPositions();
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

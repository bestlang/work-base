<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    <!--<router-link to="/cms/setting/model/add">-->
                    <el-button @click="handleAdd" type="primary" size="small">新增</el-button>
                    <!--</router-link>-->
                </div>
                <div></div>
            </div>
            <div class="l-block-body">
                <el-table
                        v-loading="loading"
                        :data="tableData"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="ID"
                            width="80">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="名称">
                    </el-table-column>
                    <el-table-column
                            label="类型"
                            width="80">
                        <template slot-scope="scope">
                            <span v-if="scope.row.is_channel" class="l-channel-color">栏目</span>
                            <span v-else>内容</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="text" @click="handleEdit(scope.row)">编辑</el-button>
                            <el-button type="text" @click="handleDelete(scope.row)">删除</el-button>
                            <el-button type="text" @click="viewContents(scope.row)">内容管理</el-button>
                            <el-button v-if="scope.row.is_channel" type="text" @click="viewSubPositions(scope.row)">内容推荐位</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
        <el-dialog title="添加类型" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form">
                <el-form-item label="名称" label-width="100px">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="类型" label-width="100px">
                    <el-radio-group v-model="form.is_channel" :disabled="form.id">
                        <el-radio :label="1" :key="1">栏目</el-radio>
                        <el-radio :label="0" :key="0">内容</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="排序值" label-width="100px">
                    <el-input type="number" v-model="form.order_factor" autocomplete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false">取消</el-button>
                <el-button type="primary" @click="submit">确定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                loading: true,
                tableData: [],
                formVisible: false,
                form: {
                    id: null,
                    name: '',
                    is_channel: '',
                    order_factor: 100
                },
            }
        },
        methods:{
            handleAdd(){
                Object.assign(this.form, {
                    id: null,
                    name: '',
                    is_channel: '',
                    order_factor: 100
                })
                this.formVisible = true;
            },
            handleEdit(row){
                Object.assign(this.form, row)
                this.formVisible = true;
            },
            viewContents(row){
                this.$store.commit(this.$types.CMS_CURRENT_POSITION, row)
                this.$router.push('/cms/position/content');
            },
            viewSubPositions(row){
                this.$store.commit(this.$types.CMS_CURRENT_CHANNEL_POSITION, row)
                this.$router.push('/cms/position/subs')
            },
            handleDelete(row){
//                this.$confirm('确定删除模型?', '提示', {
//                    confirmButtonText: '确定',
//                    cancelButtonText: '取消',
//                    type: 'warning'
//                }).then(() => {
//                    this.$http
//                        .post("/admin/cms/model/delete", {id: row.id})
//                        .then(res => {
//                            if(res.success){
//                                this.loadModels()
//                                this.$message({
//                                    type: 'success',
//                                    message: '删除成功!'
//                                });
//                            }else{
//                                this.$message({
//                                    type: 'error',
//                                    message: res.error
//                                });
//                            }
//
//                        }).catch(()=>{});
//                });
            },
            submit(){
                this.$http
                    .post("/admin/cms/position/save", this.form)
                    .then(res => {
                        // alert(JSON.stringify(res))
                        if(res.success) {
                            this.loading = true;
                            this.loadPositions();
                            this.formVisible = false;
                            this.$message({
                                message: '添加成功!',
                                type: 'success'
                            });
                        }
                    });
            },
            loadPositions(){
                this.$http
                    .get("/admin/cms/positions")
                    .then(res => {
                        this.loading = false;
                        this.tableData = res.data;
                    });
            }
        },
        created() {
            this.loadPositions();
        }
    }
</script>


<template>
    <div>
        <div v-title="'应用管理'"></div>
        <div class="l-block">
            <div class="l-block-header"></div>
            <div class="l-block-body">
                <div class="text-right">
                    <el-button type="primary" size="small" @click="addApp"><i class="if">&#xe663;</i> 新增</el-button>
                </div>
                <el-table
                        :data="apps"
                        style="width: 100%">
                    <el-table-column
                            prop="name"
                            label="名称">
                    </el-table-column>
                    <el-table-column
                            prop="version"
                            label="版本">
                    </el-table-column>
                    <el-table-column
                            prop="tplNs"
                            label="模板前缀">
                    </el-table-column>
                    <el-table-column
                            prop="uri"
                            label="模块URI路径">
                    </el-table-column>
                    <el-table-column
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="primary" @click="editApp(scope.row)" size="mini">编辑</el-button>
                            <el-button type="danger" @click="delApp(scope.row)" size="mini">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
        <el-dialog :title="title" :visible.sync="formVisible"  :close-on-click-modal="false">
            <el-form size="small" :model="form" label-width="100px">
                <el-form-item label="模块名">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="版本">
                    <el-input v-model="form.version" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="模板前缀">
                    <el-input v-model="form.tplNs" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="模块URI路径">
                    <el-input v-model="form.uri" autocomplete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false">取 消</el-button>
                <el-button type="primary" @click="doSubmit">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import api from 'sysApi'

    export default {
        data(){
            return {
                page:1,
                page_size: 15,
                total: 0,
                apps: [],
                title: '新增模块',
                formVisible: false,
                form: {
                    id: null,
                    name: '',
                    version: '',
                    tplNs: '',
                    uri: ''
                }
            }
        },
        methods: {
            async getApps(){
                const {page, page_size} = this;
                let {data} = await api.getApps({page, page_size})
                this.apps = data.apps;
                this.total = data.total || 0;
            },
            editApp(row){
                this.title = '编辑模块'
                Object.assign(this.form, {}, row)
                this.formVisible = true;
            },
            delApp(row){
                this.$confirm('确定删除模块?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.delApp({id: row.id})
                    this.$message.success('删除成功!');
                    await this.getApps()
                });
            },
            addApp(){
                this.title = '新增模块'
                this.formVisible = true;
                this.form = {
                    id: null,
                    name: '',
                    version: '',
                    tplNs: '',
                    uri: ''
                }
            },
            async doSubmit(){
                let res = await api.saveApp(this.form);
                if(res.hasError){
                    this.$message.error(res.error);
                }else{
                    this.formVisible = false;
                    this.$message.success('新增成功！');
                    await this.getApps()
                }
            }
        },
        async created(){
            await this.getApps()
        }
    }
</script>
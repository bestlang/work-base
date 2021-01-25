<template>
    <div>
        <div v-title="'模块管理'"></div>
        <div class="l-block">
            <div class="l-block-header"></div>
            <div class="l-block-body">
                <div class="text-right">
                    <el-button type="primary" size="small" @click="addModule"><i class="if">&#xe663;</i> 新增</el-button>
                </div>
                <el-table
                        :data="modules"
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
                            label="是否默认">
                        <template slot-scope="scope">
                            <span :class="['if',scope.row.is_default ? 'is_default' : 'is_normal']">{{scope.row.is_default ? '&#xe6bd;' : ''}}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="应用类型">
                        <template slot-scope="scope" :class="{}">
                            {{scope.row.type == 0 ? '基础' : '应用'}}
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="primary" @click="editModule(scope.row)" size="mini">编辑</el-button>
                            <el-button type="danger" @click="delModule(scope.row)" size="mini">删除</el-button>
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
                <el-form-item label="是否默认">
                    <el-radio-group v-model="form.is_default">
                        <el-radio :label="1">是</el-radio>
                        <el-radio :label="0">否</el-radio>
                    </el-radio-group>
                </el-form-item>
                <el-form-item label="模块类型">
                    <el-radio-group v-model="form.type">
                        <el-radio :label="0">基础</el-radio>
                        <el-radio :label="1">应用</el-radio>
                    </el-radio-group>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false">取 消</el-button>
                <el-button type="primary" @click="doSubmit">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<style scoped>
    .is_default{
        color: green;
    }
    .is_normal{
        color: #888;
    }
</style>
<script>
    import api from 'sysApi'

    export default {
        data(){
            return {
                page:1,
                page_size: 15,
                total: 0,
                modules: [],
                title: '新增模块',
                formVisible: false,
                form: {
                    id: null,
                    name: '',
                    version: '',
                    is_default: 0,
                    type: 0
                }
            }
        },
        methods: {
            async getModules(){
                const {page, page_size} = this;
                let {data} = await api.getModules({page, page_size})
                this.modules = data.modules;
                this.total = data.total || 0;
            },
            editModule(row){
                this.title = '编辑模块'
                Object.assign(this.form, {}, row)
                this.formVisible = true;
            },
            delModule(row){
                this.$confirm('确定删除模块?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.delModule({id: row.id})
                    this.$message.success('删除成功!');
                    await this.getModules()
                });
            },
            addModule(){
                this.title = '新增模块'
                this.formVisible = true;
                this.form = {
                    id: null,
                    name: '',
                    version: '',
                    is_default: 0,
                    type: 0
                }
            },
            async doSubmit(){
                let res = await api.saveModule(this.form);
                if(res.hasError){
                    this.$message.error(res.error);
                }else{
                    this.formVisible = false;
                    this.$message.success(this.form.id ? '编辑成功！':'新增成功！');
                    await this.getModules()
                }
            }
        },
        async created(){
            await this.getModules()
        }
    }
</script>
<template>
    <div>
        <div v-title="'人事变动'"></div>
        <div class="l-block">
            <div class="l-block-header">
                <div class="l-flex">
                    <el-form ref="form"  :inline="true" size="small">
                        <el-form-item label="姓名">
                            <el-input v-model="keyword" style="width: 200px;"></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="default" @click="search"><i class="if">&#xe604;</i> 搜索</el-button>
                        </el-form-item>
                    </el-form>
                    <el-form size="small">
                        <el-form-item>
                            <el-button type="primary" size="small" @click="addChange"><i class="if">&#xe663;</i> 新增</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
            <div class="l-block-body">
                <el-table
                        :data="tableData"
                        border
                        style="width: 100%">
                    <el-table-column
                            prop="date"
                            label="日期"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="姓名"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            label="变更前职位">
                        <template slot-scope="scope">
                            <span>{{scope.row.positionBefore?scope.row.positionBefore:'-'}}</span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="positionAfter"
                            label="变更后职位">
                    </el-table-column>
                    <el-table-column
                            prop="updated_at"
                            label="更新时间">
                    </el-table-column>
                    <el-table-column
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="primary" @click="handleEdit(scope.row)" size="mini">编辑</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <pager :total="params.total" :page-size="params.page_size" @current-change="currentChange"></pager>
            </div>
        </div>
        <el-dialog :title="title" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form" size="small">
                <el-form-item label="变动日期" :label-width="w">
                    <el-date-picker
                            v-model="form.date"
                            type="datetime"
                            placeholder="选择日期时间"
                            align="right"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            :picker-options="pickerOptions">
                    </el-date-picker>
                </el-form-item>
                <el-form-item label="人员" :label-width="w">
                    <el-autocomplete
                            style="width: 50%"
                            v-model="form.employee"
                            :fetch-suggestions="querySearchAsync"
                            placeholder="请输入内容"
                            @select="handleSelect"
                            :disabled="form.id?true:false"
                    ></el-autocomplete>
                </el-form-item>
                <el-form-item label="变更前职位" :label-width="w">
                    <div v-html="form.positionBefore?form.positionBefore:'<span style=\'color:#ccc\'>-</span>'"></div>
                </el-form-item>
                <el-form-item label="变更后职位" :label-width="w">
                    <tree-select v-if="!form.id" v-model="form.positionAfter" :multiple="false" :options="positions"  :default-expand-level="10" :normalizer="normalizer" />
                    <div v-else>{{form.positionAfter}}</div>
                </el-form-item>
                <el-form-item label="执行依据文件" :label-width="w">
                    <attachment v-model="form.attachment" @preview="handlePreview"></attachment>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="formVisible = false" size="small">取 消</el-button>
                <el-button type="primary" @click="submit" size="small">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import api from 'sysApi'
    import TreeSelect from '@riophae/vue-treeselect'
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'
    import pager from "@/components/pager"
    import attachment from "@/components/attachment"

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
        name: 'sniperEmployeePositionChange',
        data(){
            return {
                title: '人事变动',
                w: '100px',
                formVisible: false,
                keyword: '',
                employee: [],
                state: '',
                timeout:  null,
                positions: [],
                form:{
                    id: '',
                    date: '',
                    employee: '',
                    positionBefore: '',
                    positionAfter: '',
                    attachment: []
                },
                params:{
                    page: 1,
                    page_size: 10,
                    total: 0
                },
                pickerOptions: {
                    shortcuts: [{
                        text: '今天',
                        onClick(picker) {
                            picker.$emit('pick', new Date());
                        }
                    }, {
                        text: '昨天',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24);
                            picker.$emit('pick', date);
                        }
                    }, {
                        text: '一周前',
                        onClick(picker) {
                            const date = new Date();
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', date);
                        }
                    }]
                },
                tableData: []
            }
        },
        methods:{
            handleEdit(row){
                this.form.positionBefore = row.positionBefore
                this.form.positionAfter = row.positionAfter
                let employee = row.user.name + '-' + row.user.email
                this.form = Object.assign({}, {employee}, row)
                this.form.attachment = JSON.parse(row.attachment)
                console.log(JSON.stringify(this.form))
                this.formVisible = true
            },
            async currentChange(page){
                this.params.page = page
            },
            async getHistories(){
                let params = this.params
                let {data} = await api.sniperEmployeePositionChangeHistories(params)
                const {total, items} = data
                this.tableData = items
                this.params.total = total || this.params.total
            },
            async getEmployeeInfo(email){
                let employee = await api.sniperGetEmployeeDetail({email})
                return employee
            },
            async savePositionChange(){
                let data = this.form
                let res = await api.sniperEmployeePositionChange(data)
                if(!res.hasError){
                    this.$message.success('添加成功')
                    this.formVisible = false
                    this.getHistories()
                }else{
                    this.$message.error(res.error)
                }
            },
            async getEmployee() {
                let {data} = await  api.sniperGetEmployeeList()
                let employee = []
                for(let idx in data){
                    let e = data[idx]
                    employee.push({value: e.name + '-' + e.email})
                }
                return employee
            },
            //tree select 节点数据适应
            normalizer(node) {
                return {
                    id: node.id,
                    label: node.name,
                    children: node.children,
                }
            },
            async getPositions(){
                let res = await api.sniperGetPositionsTreeSelect({})
                let root = Object.values(res.data)[0]
                //处理数据 适应TreeSelect组件
                removeEmptyChildren(root)
                this.positions = [root]
            },
            querySearchAsync(queryString, cb) {
                var employee = this.employee;
                var results = queryString ? employee.filter(this.createStateFilter(queryString)) : employee;

                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    cb(results);
                }, 800 * Math.random());
            },
            createStateFilter(queryString) {
                return (state) => {
                    return (state.value.toLowerCase().indexOf(queryString.toLowerCase()) !== -1);
                };
            },
            handleSelect(item) {
                console.log(item);
            },
            async search(){
                this.params = {page: 1, page_size:10, keyword: this.keyword}
                await this.getHistories()
            },
            addChange(){
                for(let key in this.form){
                    this.form[key] = ''
                }
                this.formVisible = true
            },
            async submit(){
                await this.savePositionChange()
            },
            handlePreview(file){
                window.open(file.url, '_blank')
            }
        },
        watch:{
            async ['form.employee'](val){
                if(val){
                    let index = val.indexOf('-')
                    let email = val.substr(index+1)
                    let employee = await this.getEmployeeInfo(email);
                    if(employee.data && employee.data.position && !this.form.id){
                        this.form.positionBefore = employee.data.position.name
                    }
                }
            },
            async ['params.page'](val){
                await this.getHistories()
            }
        },
        components: { TreeSelect, pager, attachment },
        async mounted() {
            await this.getPositions();
            this.employee = await this.getEmployee();
            await this.getHistories()
        }
    }
</script>
<style lang="less">

</style>
<template>
    <div>
        <div v-title="'离职管理'"></div>
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
                            label="离职日期"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="姓名"
                            width="180">
                    </el-table-column>
                    <el-table-column
                            label="离职申请表">
                        <template slot-scope="scope">
                            <span v-for="item in JSON.parse(scope.row.apply)"><a :href="item.url" target="_blank" style="color: #00a2d4;margin-right: 20px;display: inline-block;">{{item.name}}</a></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="交接单">
                        <template slot-scope="scope">
                            <span v-for="item in JSON.parse(scope.row.handover)"><a :href="item.url" target="_blank" style="color: #00a2d4;margin-right: 20px;display: inline-block;">{{item.name}}</a></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="退工手续备案表">
                        <template slot-scope="scope">
                            <span v-for="item in JSON.parse(scope.row.record)"><a :href="item.url" target="_blank" style="color: #00a2d4;margin-right: 20px;display: inline-block;">{{item.name}}</a></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            label="其他文件">
                        <template slot-scope="scope">
                            <span v-for="item in JSON.parse(scope.row.other)"><a :href="item.url" target="_blank" style="color: #00a2d4;margin-right: 20px;display: inline-block;">{{item.name}}</a></span>
                        </template>
                    </el-table-column>
                    <el-table-column
                            prop="updated_at"
                            label="更新时间">
                    </el-table-column>
                </el-table>
                <pager :total="params.total" :page-size="params.page_size" @current-change="currentChange"></pager>
            </div>
        </div>
        <el-dialog :title="title" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form" size="small">
                <el-form-item label="离职日期" :label-width="w">
                    <el-date-picker
                            v-model="form.date"
                            type="datetime"
                            placeholder="选择日期时间"
                            align="right"
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
                            :disabled="!form.date"
                    ></el-autocomplete>
                </el-form-item>
                <el-form-item label="离职申请表" :label-width="w">
                    <attachment v-model="form.apply" @onPreview="onPreview"></attachment>
                </el-form-item>
                <el-form-item label="交接单" :label-width="w">
                    <attachment v-model="form.handover" @onPreview="onPreview"></attachment>
                </el-form-item>
                <el-form-item label="退工手续备案表" :label-width="w">
                    <attachment v-model="form.record" @onPreview="onPreview"></attachment>
                </el-form-item>
                <el-form-item label="其他单据" :label-width="w">
                    <attachment v-model="form.other" @onPreview="onPreview"></attachment>
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
    import {formatDateTime} from "sysApi/util"
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
        name: 'sniperEmployeeWastage',
        data(){
            return {
                title: '离职管理',
                w: '110px',
                formVisible: false,
                keyword: '',

                employee: [],
                state: '',
                timeout:  null,

                positions: [],

                form:{
                    date: '',
                    employee: '',
                    apply: [],
                    handover: [],
                    record: [],
                    other: []
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
            onPreview(file){
                window.open(file.url, '_blank')
            },
            async currentChange(page){
                this.params.page = page
            },
            async getHistories(){
                let params = this.params
                let {data} = await api.sniperEmployeeWastageHistories(params)
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
                let res = await api.sniperSaveEmployeeWastage(data)
                if(!res.hasError){
                    this.$message.success('添加成功')
                    this.formVisible = false
                    //this.getHistories()
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
                // for(let key in this.form){
                //     this.form[key] = ''
                // }
                this.form.date = ''
                this.form.employee = ''

                this.form.apply = []
                this.form.handover = []
                this.form.record = []
                this.form.other = []

                this.formVisible = true
            },
            async submit(){
                await this.savePositionChange()
            }
        },
        watch:{
            ['form.date'](val){
                if(val){
                    if(!/\d{4}\-\d{2}\-\d{2}/.test(val)){
                        this.form.date = formatDateTime(val)
                    }
                }
            },
            async ['form.employee'](val){
                if(val){
                    let index = val.indexOf('-')
                    let email = val.substr(index+1)
                    let employee = await this.getEmployeeInfo(email);
                    if(employee.data && employee.data.position){
                        this.form.positionBefore = employee.data.position.name
                    }else{
                        this.form.positionBefore = ''
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
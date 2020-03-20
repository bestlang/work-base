<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div>
                    <router-link class="l-cursor" to="/cms/position/position" tag="span"><span class="iconfont">&#xe601;</span> 返回</router-link>
                    <el-divider direction="vertical"></el-divider>
                    <span>「{{currentChannelPosition.name}}」内容推荐位</span>
                </div>
                <el-button type="primary" size="small" @click="handleAdd">新增</el-button>
            </div>
            <div class="l-block-body">
                <el-table
                        :data="subPositions"
                        style="width: 100%">
                    <el-table-column
                            prop="id"
                            label="ID"
                            width="100">
                    </el-table-column>
                    <el-table-column
                            prop="name"
                            label="推荐位名">
                    </el-table-column>
                    <el-table-column
                            prop="order_factor"
                            label="排序值">
                    </el-table-column>
                    <el-table-column
                            width="300"
                            label="操作">
                        <template slot-scope="scope">
                            <el-button type="text" @click="editChannel(scope.row)">编辑</el-button>
                            <el-button type="text" @click="deleteChannel(scope.row)">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="l-block-bottom"></div>
        </div>
        <el-dialog title="添加类型" :visible.sync="formVisible" :close-on-click-modal="false">
            <el-form :model="form">
                <el-form-item label="名称" label-width="100px">
                    <el-input v-model="form.name" autocomplete="off"></el-input>
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
    import api from '../../../api/index'
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {
                formVisible: false,
                form: {
                    id: null,
                    name: '',
                    is_channel: 0,
                    order_factor: 100
                },
                subPositions: []
            }
        },
        computed:{
            ...mapGetters(['currentChannelPosition']),
        },
        methods:{
            editChannel(row){
                Object.assign(this.form, row)
                this.formVisible = true;
            },
            deleteChannel(){

            },
            handleAdd(){
                Object.assign(this.form, {
                    id: null,
                    name: '',
                    is_channel: 0,
                    order_factor: 100,
                    parent_id: this.currentChannelPosition.id
                })
                this.formVisible = true;
            },
            async getSubPositions({id}){
                let res = await api.getSubPositions({id})
                this.subPositions = res.data;
            },
            async submit(){
                let res = await api.savePosition(this.form)
                if(res.success) {
                    await this.getSubPositions(this.currentChannelPosition)
                    this.formVisible = false;
                    let message = '添加成功!';
                    if(this.form.id){
                        message = '更新成功!';
                    }
                    this.$message({
                        message: message,
                        type: 'success'
                    });
                }
            },
        },
        async mounted(){
            await this.getSubPositions(this.currentChannelPosition)
        }
    }
</script>
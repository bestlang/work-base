<style lang="less" scoped>
    .l-content-list{
        display: flex;
        flex-flow: row nowrap;
        min-height: calc(100vh - 50px - 20px);
        margin:-20px 0 -20px -20px;
        overflow-x: hidden;
    .l-tree-content{
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-flow: row nowrap;
        box-sizing: border-box;
        width: calc(100% - 240px);
    }
    }
</style>
<template>
    <div class="l-content-list">
        <div v-title="formTitle"></div>
        <div class="l-tree-content">
            <div class="l-block">
                <div class="l-block-header">
                    <div>
                        <span class="l-go-back" @click="goback"><span class="iconfont">&#xe601;</span>返回</span>
                        <el-divider direction="vertical"></el-divider>
                        <span>{{formTitle}}</span>
                    </div>
                </div>
                <div class="l-block-body">
                    <el-form label-width="100px">
                        <el-form-item label="广告名称" :label-width="w">
                            <el-input name="name" v-model="form.name"></el-input>
                        </el-form-item>
                        <el-form-item label="广告位" :label-width="w">
                            <el-select v-model="form.position_id" placeholder="请选择">
                                <el-option
                                        v-for="item in positions"
                                        :key="item.id"
                                        :label="item.name"
                                        :value="item.id">
                                </el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="启用" :label-width="w">
                            <el-radio-group v-model="form.enabled">
                                <el-radio :label="1">是</el-radio>
                                <el-radio :label="0">否</el-radio>
                            </el-radio-group>
                        </el-form-item>


                        <el-form-item label="起止时间" :label-width="w">
                            <el-date-picker
                                    v-model="form.time_range"
                                    type="datetimerange"
                                    range-separator="至"
                                    start-placeholder="开始日期"
                                    end-placeholder="结束日期">
                            </el-date-picker>
                        </el-form-item>

                        <el-form-item label="类型" :label-width="w">
                            <el-radio-group v-model="form.type">
                                <el-radio :label="1">图片</el-radio>
                                <el-radio :label="2">文字</el-radio>
                                <el-radio :label="3">代码</el-radio>
                            </el-radio-group>
                        </el-form-item>
                        <template v-if="form.type==1">
                            <el-form-item label="图片" :label-width="w">
                                <image-upload v-model="form.image"></image-upload>
                            </el-form-item>

                            <el-form-item label="窄屏图片" :label-width="w">
                                <image-upload v-model="form.tiny_image"></image-upload>
                            </el-form-item>
                        </template>
                        <el-form-item label="代码" :label-width="w" v-if="form.type==3">
                            <el-input type="textarea" v-model="form.code"></el-input>
                        </el-form-item>
                        <el-form-item label="文字内容" :label-width="w" v-if="form.type==2">
                            <el-input name="url" v-model="form.text"></el-input>
                        </el-form-item>
                        <el-form-item label="URL" :label-width="w" v-if="form.type!=3">
                            <el-input name="url" v-model="form.url"></el-input>
                        </el-form-item>
                        <el-form-item label="跳转方式" :label-width="w">
                            <el-radio-group v-model="form.target">
                                <el-radio :label="'_black'">新页面</el-radio>
                                <el-radio :label="'_self'">当前页</el-radio>
                            </el-radio-group>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" size="small" @click="saveAd">提交</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import ueditorConfig from "../../../store/ueditor";
    import imageUpload from "@/components/imageUpload"
    import attachment from "@/components/attachment"
    import api from 'sysApi'
    import {formatDateTime} from "../../../api/util"

    export default {
        data() {
            return {
                formTitle: '添加广告',
                w: '80px',
                positions: [],
                form:{
                    id: '',
                    name: '',
                    position_id: '',
                    enabled: 1,
                    start_time: null,
                    end_time: null,
                    time_range:[this.start_time, this.end_time],
                    type: 1,//形式1.图片2.文字3.代码
                    url: '',
                    text: '',
                    code: '',
                    image: null,
                    tiny_image: null,
                    target: '_black'
                }
            }
        },
        components:{
            imageUpload,
            attachment
        },
        methods: {
            goback(){
                this.$router.push('/cms/operation/ads')
            },
            async saveAd(){
                this.form.start_time = formatDateTime(this.form.time_range[0])
                this.form.end_time = formatDateTime(this.form.time_range[1])
                let res = await api.saveAd(this.form)
                if(res.success){
                    let msg = '修改成功!';
                    this.form.id || (msg = '添加成功!')
                    this.$message({
                        type: 'success',
                        message: msg
                    });
                    this.goback()
                }else{
                    alert(JSON.stringify(res))
                }
            },
            async getAdPositions(){
                let res = await api.getAdPositions()
                this.positions = res.data
            },

            async getAd(id){
                if(id){
                    let res = await api.getAd({id})
                    Object.assign(this.form, res.data)
                    this.form.time_range = [res.data.start_time, res.data.end_time]
                }
            }
        },
        async mounted() {
            let id = parseInt(this.$route.query.id) || 0;
            await this.getAd(id)
            await this.getAdPositions()
        }
    }
</script>
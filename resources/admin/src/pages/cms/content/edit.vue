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
        <div v-title="'内容管理'"></div>
        <!--<channel-tree @nodeClick="handleNodeClick" :title="'栏目选择'" :selectedKey="channel_id"></channel-tree>-->
        <div class="l-tree-content">
            <div class="l-block" v-if="currentModel">
                <div class="l-block-header">
                    <div>
                        <span class="l-go-back" @click="goback"><span class="iconfont">&#xe601;</span>返回</span>
                        <el-divider direction="vertical"></el-divider>
                        <!--<i class="iconfont">&#xe64c;</i>「」-->
                        <span v-if="currentChannel">在<span style="font-weight: 700">“{{currentChannel.name}}”</span>下{{formTitle}}</span>
                    </div>
                </div>
                <div class="l-block-body">
                    <el-form label-width="100px">
                        <template v-for="(item, index) in currentModel.fields">

                            <el-form-item v-if="item.type=='text'" :label="item.label">
                                <el-input :key="index" :name="item.field" v-model="form[item.field]"></el-input>
                            </el-form-item>

                            <el-form-item v-if="item.type=='checkbox' && Array.isArray(form[item.field])" :label="item.label">
                                <el-checkbox-group v-model="form[item.field]">
                                    <el-checkbox :label="option.value" v-for="option in item.extra">{{option.name}}</el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item v-if="item.type=='image'" :label="item.label">
                                <image-upload v-model="form[item.field]"></image-upload>
                            </el-form-item>

                            <el-form-item v-if="item.type=='multiple-image' && form[item.field]" :label="item.label">
                                <multiple-image-upload v-model="form[item.field]"></multiple-image-upload>
                            </el-form-item>

                            <el-form-item v-if="item.type=='attachment' && form[item.field]" class="l-mb-22" :label="item.label">
                                <div>
                                    <attachment v-model="form[item.field]"></attachment>
                                </div>
                            </el-form-item>

                            <el-form-item v-if="item.type=='textarea'" :label="item.label">
                                <el-input type="textarea" v-model="form[item.field]"></el-input>
                            </el-form-item>

                            <el-form-item v-if="item.type=='content'" class="l-mb-22" :label="item.label">
                                <div>
                                    <vue-ueditor-wrap v-model="form[item.field]" :config="ueditorConfig"></vue-ueditor-wrap>
                                </div>
                            </el-form-item>

                        </template>
                        <el-form-item label="编辑推荐位" v-if="contentPositions && contentPositions.length">
                            <el-checkbox-group  v-model="form['positions']">
                                <el-checkbox :label="option.id" v-for="option in contentPositions">{{option.name}}</el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" size="small" @click="saveContent">提交</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import channelTree from "../components/channelTree";
    import VueUeditorWrap from 'vue-ueditor-wrap';
    import ueditorConfig from "../../../store/ueditor";
    import imageUpload from "@/components/imageUpload"
    import multipleImageUpload from "@/components/multipleImageUpload"
    import attachment from "@/components/attachment"
    import {mapGetters} from 'vuex'
    import api from '../../../api/index'

    export default {
        data() {
            return {
                checkList:[],
                showSwitch: false,
                contents: [],
                formTitle: '编辑内容',
                form:{
                    positions:[]
                },
                ueditorConfig: ueditorConfig,
                contentPositions: [],
                channel_id: 0,
                content_id: 0
            }
        },
        components:{
            'channel-tree': channelTree,
            VueUeditorWrap,
            imageUpload,
            multipleImageUpload,
            attachment
        },
        computed:{
            ...mapGetters([
                'parentChannel',
                'currentChannel',
                'currentModel',
            ]),
        },
        watch:{
            async content_id(val){
                if(val){
                    await this.loadWholeContent(val)
                    let {data} = await api.getCmsChannelWhole({id: this.channel_id})
                    this.$store.commit(this.$types.CMS_CURRENT_CHANNEL, data)
                    await this.loadContentPositions(this.currentChannel.id);
                }
            }
        },
        methods: {
            goback(){
                this.$router.push('/cms/content?channel_id='+this.currentChannel.id)
            },
            async loadWholeContent(id){
                let res = await api.getWholeContent({id});

                let content = res.data;
                this.channel_id = content.channel_id;
                let currentModel = res.data.model;
                currentModel.fields = currentModel.fields.filter(item => { return !item.is_channel })

                let contentFields = ['channel_id', 'model_id', 'title', 'keywords', 'description'];

                this.$set(this.form, 'id', id);

                contentFields.forEach( field => {this.$set(this.form, field, content[field])} );

                if(content.contents && content.contents.length){
                    content.contents.forEach( item => {this.$set(this.form, item.field, item.value)} );
                }

                if(content.metas && content.metas.length){
                    content.metas.forEach(
                        item => {
                            this.$set(this.form, item.field, item.value);
                        });
                }

                if(content.positions){
                    this.$set(this.form, 'positions', content.positions)
                }

                this.$store.dispatch(this.$types.CMS_CURRENT_MODEL, currentModel)
            },
            async saveContent(){
                if(!this.form.channel_id && !this.form.model_id){
                    this.$set(this.form, 'model_id', this.currentModel.id);
                    this.$set(this.form, 'channel_id', this.currentChannel.id)
                }
                let res = await api.saveContent(this.form)
                if(res.success){
                    this.$message({
                        type: 'success',
                        message: '添加成功!'
                    });
                    this.goback()
                }
            },

            async handleNodeClick(node, ...params){
                let channel = node[0]
                this.channel_id = channel.id
                this.$store.dispatch(this.$types.CMS_CURRENT_CHANNEL, channel);
                this.$store.dispatch(this.$types.CMS_PARENT_CHANNEL, channel);
                await this.loadModel(channel.model.id)
                await this.loadContentPositions()
            },
            async loadModel(id){
                let res = await api.getModel({id})
                let currentModel = res.data;
                // 过滤掉模型中属于栏目的字段
                currentModel.fields = currentModel.fields.filter(item => { return !item.is_channel })
                this.$store.dispatch(this.$types.CMS_CURRENT_MODEL, currentModel)
                for(let idx in this.currentModel.fields){
                    let item = this.currentModel.fields[idx];
                    // 重置表单
                    this.$set(this.form, item.field, '');
                    if(item.type == 'checkbox' || item.type == 'multiple-image'){
                        this.$set(this.form, item.field, []);
                    }
                }
                this.$set(this.form, 'positions', [])
            },
            async loadContentPositions(channel_id=0){
                if(!channel_id){
                    if(this.currentChannel && this.currentChannel.id){
                        channel_id = this.currentChannel.id;
                    }
                }
                // 没有选定的栏目, 不进行[可选推荐位]的加载
                if(!channel_id){
                    return;
                }
                let res = await api.getContentPositions({channel_id})
                this.contentPositions = res.data
            }
        },
        async mounted() {
            this.content_id = parseInt(this.$route.query.content_id || 0);
            this.$store.dispatch('toggleState');
        }
    }
</script>
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
    .price{
        width: 200px;
    }
</style>
<template>
    <div class="l-content-list">
        <div v-title="'内容管理'"></div>
        <channel-tree @nodeClick="handleNodeClick" :title="'栏目选择'" :selectedKey="channel_id"></channel-tree>
        <div class="l-tree-content">
            <div class="l-block" v-if="currentModel">
                <div class="l-block-header">
                    <div>
                        <span class="l-go-back" @click="goBack"><span class="iconfont">&#xe601;</span>返回</span>
                        <el-divider direction="vertical"></el-divider>
                        <!--<i class="iconfont">&#xe64c;</i>「」-->
                        <span>在<span style="font-weight: 700">“{{contentCurrentChannel.name}}”</span>下{{formTitle}}</span>
                    </div>
                </div>
                <div class="l-block-body">
                    <el-form label-width="100px" size="small">
                        <template v-for="(item, index) in currentModel.fields">

                            <el-form-item v-if="item.type=='text'" :label="item.label">
                                <el-input :key="index" :name="item.field" v-model="form[item.field]"></el-input>
                            </el-form-item>

                            <el-form-item v-if="item.type=='number'" :label="item.label">
                                <el-input class="price" type="number" :key="index" :name="item.field" v-model="form[item.field]"></el-input>
                            </el-form-item>

                            <el-form-item v-if="item.type=='checkbox' && Array.isArray(form[item.field])" :label="item.label">
                                <el-checkbox-group v-model="form[item.field]">
                                    <el-checkbox :label="option.value" v-for="option in item.extra">{{option.name}}</el-checkbox>
                                </el-checkbox-group>
                            </el-form-item>

                            <el-form-item v-if="item.type=='image'" :label="item.label">
                                <image-upload v-model="form[item.field]"></image-upload>
                            </el-form-item>

                            <el-form-item v-if="item.type=='multiple-image'" :label="item.label">
                                <multiple-image-upload v-model="form[item.field]"></multiple-image-upload>
                            </el-form-item>

                            <el-form-item v-if="item.type=='attachment'" class="l-mb-22" :label="item.label">
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
                        <el-form-item label="标签">
                            <tag v-model="form['tags']"></tag>
                        </el-form-item>
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
    import ueditorConfig from "sysStore/ueditor";
    import imageUpload from "@/components/imageUpload"
    import multipleImageUpload from "@/components/multipleImageUpload"
    import attachment from "@/components/attachment"
    import tag from "@/components/tag"
    import {mapGetters} from 'vuex'
    import api from 'sysApi'

    export default {
        name: 'cmsContentAdd',
        data() {
            return {
                checkList:[],
                showSwitch: false,
                contents: [],
                formTitle: '添加内容',
                form:{
                    positions:[]
                },
                ueditorConfig: ueditorConfig,
                contentPositions: [],
                channel_id: 0
            }
        },
        components:{
            'channel-tree': channelTree,
            VueUeditorWrap,
            imageUpload,
            multipleImageUpload,
            attachment,
            tag
        },
        computed:{
            ...mapGetters([
                'parentChannel',
                'currentChannel',
                'contentCurrentChannel',
                'currentModel',
            ]),
        },
        watch:{
            async channel_id(val){
                if(val){
                    let {data} = await api.getCmsChannelWhole({id: val})
                    this.$store.dispatch(this.$types.cmsContentCurrentChannel, data);
                    await this.loadModel(data.model_id)
                }
            }
        },
        methods: {
            assignTags(payload){
                this.$set(this.form, 'tags', payload.map(tag => tag.name).join(','));
            },
            goBack(){
                this.$router.push('/cms/content?channel_id='+this.channel_id)
            },
            async saveContent(){
                if(!this.form.channel_id && !this.form.model_id){
                    this.$set(this.form, 'model_id', this.currentModel.id);
                    this.$set(this.form, 'channel_id', this.contentCurrentChannel.id)
                }
                let res = await api.saveContent(this.form)
                if(res.success){
                    this.$message.success('添加成功!');
                    this.goBack()
                }
            },

            async handleNodeClick(node, ...params){
                let channel = node[0]
                this.channel_id = channel.id
                this.$store.dispatch(this.$types.cmsContentCurrentChannel, channel);
                //this.$store.dispatch(this.$types.cmsParentChannel, channel);
                await this.loadModel(channel.model.id)
                await this.loadContentPositions()
            },
            async loadModel(id){
                let res = await api.getModel({id})
                let currentModel = res.data;
                // 过滤掉模型中属于栏目的字段
                currentModel.fields = currentModel.fields.filter(item => { return !item.is_channel })
                this.$store.dispatch(this.$types.cmsCurrentModel, currentModel)
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
                    if(this.contentCurrentChannel && this.contentCurrentChannel.id){
                        channel_id = this.contentCurrentChannel.id;
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
            this.channel_id = parseInt(this.$route.query.channel_id) || 0;
            await this.loadContentPositions(this.channel_id);
            //this.$store.dispatch('collapse');
            this.$set(this.form, 'tags', [{id: 1, name: ''}])
        }
    }
</script>
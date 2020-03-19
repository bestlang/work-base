<template>
    <el-row>
        <el-col :span="18">
            <el-form ref="form" :model="form" label-width="120px">

                <el-form-item label="类型">
                    <el-radio-group v-model="form.type">
                        <el-radio :label="type.id" v-for="(type, index) in types" :key="index">{{type.name}}</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="适应于">
                    <el-radio-group v-model="form.applicable">
                        <el-radio :label="index" v-for="(applicable, index) in activityApplicables" :key="index">{{applicable}}</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item label="名称">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>

                <el-form-item label="缩略图">
                    <el-upload
                            class="avatar-uploader"
                            :action="uploadUrl"
                            :on-remove="thumbnailRemove"
                            :on-success="thumbnailSuccess"
                            :file-list="thumbnailFileList"
                            list-type="picture-card"
                            :show-file-list="false"
                            name="file"
                            :headers="headers"
                    >
                        <img v-if="form.thumbnail" :src="form.thumbnail" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>

                <el-form-item label="缩略图URL">
                    <el-input v-model="form.thumbnail"></el-input>
                </el-form-item>

                <el-form-item label="开始">
                    <el-col :span="11">
                        <el-date-picker value-format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="选择日期" v-model="form.start_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                </el-form-item>

                <el-form-item label="结束">
                    <el-col :span="11">
                        <el-date-picker value-format="yyyy-MM-dd HH:mm:ss" type="datetime" placeholder="选择日期" v-model="form.end_time" style="width: 100%;"></el-date-picker>
                    </el-col>
                </el-form-item>

                <el-form-item label="描述">
                    <el-input type="textarea" v-model="form.detail"></el-input>
                </el-form-item>

                <el-form-item label="相册">
                    <el-upload
                            class=""
                            :on-preview="preview"
                            :action="uploadUrl"
                            :on-remove="galleryRemove"
                            :on-success="gallerySuccess"
                            :file-list="galleryFileList"
                            list-type="picture-card"
                            :multiple="true"
                            name="file"
                            :headers="headers"
                    >
                        <el-button size="small" type="primary">点击上传</el-button>
                        <div slot="tip" class="el-upload__tip">
                            <!--只能上传jpg/png文件，且不超过500kb-->
                        </div>
                    </el-upload>
                </el-form-item>

                <el-form-item label="状态">
                    <el-radio-group v-model="form.status">
                        <el-radio :label="status.id" v-for="(status, index) in statusArr" :key="index">{{status.name}}</el-radio>
                    </el-radio-group>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="onSubmit">立即更新</el-button>
                    <el-button>取消</el-button>
                </el-form-item>
            </el-form>
        </el-col>
    </el-row>
</template>
<script>
    export default {
        data() {
            return {
                uploadUrl: this.SITE_URL + '/api/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
                },
                activityId:null,
                form: {
                    id:null,
                    name: "",
                    start_time: "",
                    end_time: "",
                    type: 1,
                    detail: "",
                    thumbnail: "",
                    galleries: [],
                    status: 0,
                    applicable: 0
                },
                statusArr: [],
                thumbnailFileList: [],
                galleryFileList: []
            }
        },
        computed:{
            types(){
                return this.$store.getters.activityTypes;
            },
            activityApplicables(){
                return this.$store.getters.activityApplicables;
            },
        },
        watch: {
            activityId(newVal){
                this.fetch("/admin/activity/activity", {activityId: newVal})
                    .then(res => {
                        if(res.code == 200){
                            let newFormData = {}
                            let a = res.data.activity
                            Object.assign(newFormData, {
                                id: a.id,
                                name: a.name,
                                start_time: a.start_time,
                                end_time: a.end_time,
                                type: a.type,
                                detail: a.detail,
                                thumbnail: a.thumbnail,
                                galleries: a.galleries.map(v => v.thumbnail),
                                status: a.status_original,
                                applicable: a.applicable
                            })
                            this.statusArr = a.statusArr
                            this.form = newFormData;
                            this.thumbnailFileList = [a.thumbnail].map(function(x){return {name: "", url: x};})
                            this.galleryFileList = a.galleries.map(function(x){return {name: "", url: x.thumbnail};})
                            console.log(`this.form`, this.form)
                        }else{
                            this.errorMessage("出错了");
                        }
                    });
            }
        },
        mounted(){
            this.activityId = this.$route.query.activityId
        },
        methods: {
            preview(file){window.open(file.url)},
            thumbnailSuccess(response, file, fileList){
                this.form.thumbnail = response.data.file
            },
            thumbnailRemove(file, fileList){
                this.form.thumbnail = ""
            },

            gallerySuccess(response, file, fileList){
                this.form.galleries.push(response.data.file)
            },
            async galleryRemove(file, fileList){
                this.form.galleries = this.form.galleries.filter(x => x != file.url)
                let params = {activityId: this.activityId, thumbnail:file.url}
                await this.fetch("/admin/activity/gallery/delete", params, 'post')
            },
            async onSubmit() {
                let res = await this.fetch("/admin/activity/save", this.form, 'post')
                if(res.code == 200){
                    this.successMessage('更新成功');
                    this.$router.push('/activity/list');
                }else{
                    this.errorMessage("出错了");
                }
            }
        }
    }
</script>

<style scoped>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 146px;
        height: 146px;
        line-height: 146px;
        text-align: center;
    }
    .avatar {
        width: 146px;
        height: 146px;
        display: block;
    }
</style>
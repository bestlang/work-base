<template>
    <el-upload
            :on-preview="preview"
            :action="uploadUrl"
            :on-remove="uploadRemove"
            :on-success="uploadSuccess"
            list-type="picture-card"
            :multiple="true"
            :file-list="vals"
            name="file"
            :headers="headers"
    >
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip"></div>
    </el-upload>
</template>
<script>
    //import custom from '@/../config/custom'

    export default {
        props:['value'],
        data(){
            return {
                uploadUrl: this.SITE_URL + '/api/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
                },
                disabled: false,
                vals: []
            }
        },
        methods:{
            preview(file){
                window.open(file.response.data.file)
            },
            uploadRemove(file){
                this.vals = this.vals.filter( item => { return item.url != file.response.data.file});
                this.$emit('input', this.vals)
            },
            uploadSuccess(response, file, fileList){
                const item = {description: '', url: response.data.file}
                this.vals.push(item);
                this.$emit('input', this.vals)
            }
        },
        mounted: function () {
            this.$nextTick(() => {
                this.vals = this.value
            })
        }
    }
</script>
<style lang="less">
    .avatar-uploader .el-upload{
        border: 1px solid #DCDFE6;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-sizing: content-box;
        padding: 8px;
        border-radius: 4px;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #DCDFE6;
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
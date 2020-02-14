<template>
    <el-upload
            class="avatar-uploader"
            :action="uploadUrl"
            :on-success="uploadSuccess"
            list-type="picture-card"
            :show-file-list="false"
            name="file"
            :headers="headers"
    >
        <img v-if="value" :src="value" class="avatar">
        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
</template>
<script>
    import custom from '@/../config/custom'

    export default {
        props:['value'],
        data(){
            return {
                uploadUrl: custom.SITE_URL + '/api/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
                },
            }
        },
        methods:{
            uploadSuccess(response, file, fileList){
                this.$emit('input', response.data.file)
            }
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
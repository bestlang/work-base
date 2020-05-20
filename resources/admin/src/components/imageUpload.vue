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
        <!--<i v-else class="el-icon-plus avatar-uploader-icon"></i>-->
        <el-button v-else size="mini" icon="el-icon-plus" circle></el-button>
    </el-upload>
</template>
<script>
    import { getPrefix } from '../api/util'

    export default {
        props:['value'],
        data(){
            let accessToken = localStorage.getItem('accessToken');

            return {
                uploadUrl: this.SITE_URL + '/' + getPrefix() + '/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-CSRF-TOKEN': this.$store.getters[this.$types.CSRF]
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
<style scoped>
    .avatar-uploader >>> .el-upload{
        border: 1px solid #DCDFE6;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-sizing: content-box;
        padding: 8px;
        border-radius: 4px;
    }
    .avatar {
        width: 146px;
        height: 146px;
        display: block;
    }
    .avatar-uploader >>> .el-upload--picture-card i{
        font-weight: 700;
        font-size: 20px;
        color: #c0c0c0;
    }
    .avatar-uploader >>> .el-upload--picture-card button{
        border: none;
        background: transparent;
    }
</style>
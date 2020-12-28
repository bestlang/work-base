<template>
    <el-upload
            class="avatar-uploader"
            :action="uploadUrl"
            :on-success="uploadSuccess"
            :on-error="uploadError"
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
    import { getPrefix } from 'sysApi/util'
    import {mapGetters} from 'vuex'

    export default {
        props:['value'],
        data(){
            return {
                uploadUrl: this.SITE_URL + '/' + getPrefix() + '/admin/file/upload'
            }
        },
        computed:{
            headers(){
                let getters = this.$store.getters
                return {
                    'Authorization': 'Bearer ' + getters['accessToken'],
                    'X-CSRF-TOKEN': getters['csrf']
                }
            }
        },
        methods:{
            uploadSuccess(response, file, fileList){
                this.$emit('input', response.data.file)
            },
            async uploadError(){
                this.$message.error('本次上传出错请重新上传');
                await this.$store.dispatch(this.$types.csrf)
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
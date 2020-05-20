<template>
    <el-upload
            class="multiple-image-upload"
            :on-preview="preview"
            :action="uploadUrl"
            :on-remove="uploadRemove"
            :on-success="uploadSuccess"
            list-type="picture-card"
            :multiple="true"
            :file-list="vals"
            name="file"
            :show-file-list="true"
            :headers="headers"
    >
        <el-button size="mini" icon="el-icon-plus" circle></el-button>
        <div slot="tip" class="el-upload__tip"></div>
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
                disabled: false,
                vals: [],
                updated: []
            }
        },
        methods:{
            preview(file){
                window.open(file.url || file.response.data.file)
            },
            uploadRemove(file, fileList){
                this.updated = this.vals.filter( item => { return item.url != file.url} );
                this.$emit('input', this.updated)
//                this.vals = updated
            },
            uploadSuccess(response, file, fileList){
                const item = {description: '', url: response.data.file}
                this.updated = [...this.updated, item]
                this.$emit('input', this.updated)
//                this.vals = updated
            }
        },
        mounted: function () {
            if(this.value){
                this.vals = [...this.value]
                this.updated = [...this.value]
            }
        }
    }
</script>
<style scoped>
    .multiple-image-upload >>> .el-upload--picture-card, .multiple-image-upload >>> .el-upload-list--picture-card li{
        border: 1px solid #DCDFE6;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-sizing: content-box;
        padding: 8px;
        border-radius: 4px;
    }
    .multiple-image-upload >>> .el-upload--picture-card i{
        font-weight: 700;
        font-size: 20px;
        color: #c0c0c0;
    }
    .multiple-image-upload >>> .el-upload--picture-card button{
        border: none;
        background: transparent;
    }
</style>
<template>
    <el-upload
            class=""
            :action="uploadUrl"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            :on-success="uploadSuccess"
            :on-preview="handlePreview"
            multiple
            :file-list="fileList"
            name="file"
            :show-file-list="true"
            :headers="headers"
    >
        <el-button size="mini" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip"></div>
    </el-upload>
</template>
<script>
    import { getPrefix } from 'sysApi/util'

    export default {
        props:['value'],
        data(){
            let accessToken = localStorage.getItem('accessToken')
            return {
                uploadUrl: this.SITE_URL + '/' + getPrefix() + '/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + accessToken,
                    'X-CSRF-TOKEN': this.$store.getters[this.$types.csrf]
                },
                disabled: false,
                fileList: []
            }
        },
        watch:{
            value(){
                this.fileList = [...this.value]
            }
        },
        methods:{
            beforeRemove(file, fl) {
                return this.$confirm(`确定移除 ${ file.name }？`);
            },
            handleRemove(file, fl){
                this.fileList = this.fileList.filter( item => { return item.url != file.url} )
                this.$emit('input', this.fileList)
            },
            handlePreview(file){
                this.$emit('preview', file)
            },
            uploadSuccess(response, file, fl){
                const item = {name: file.name, url: file.response.data.file}
                this.fileList = [...this.fileList, item]
                this.$emit('input', this.fileList)
            }
        },
        mounted: function () {
            if(this.value){
                this.fileList = [...this.value]
            }
        }
    }
</script>
<style scoped>
</style>
<template>
    <el-upload
            class=""
            :on-preview="handlePreview"
            :action="uploadUrl"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            :on-success="uploadSuccess"
            multiple
            :file-list="fileList"
            name="file"
            :show-file-list="true"
            :headers="headers"
    >
        <el-button size="small" type="primary">点击上传</el-button>
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
                    'X-CSRF-TOKEN': this.$store.getters[this.$types.csrf]
                },
                disabled: false,
                fileList: []
            }
        },
        methods:{
            handlePreview(){},
            beforeRemove(file, fl) {
                return this.$confirm(`确定移除 ${ file.name }？`);
            },
            preview(file){
                window.open(file.response.data.file)
            },
            handleRemove(file, fl){
                this.fileList = this.fileList.filter( item => { return item.url != file.url} );
                this.$emit('input', this.fileList)
            },
            uploadSuccess(response, file, fl){
                console.log(JSON.stringify(file))
                const item = {name: file.name, url: file.response.data.file}
                this.fileList = [...this.fileList, item]
                console.log(`-----------`, JSON.stringify(this.fileList))
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
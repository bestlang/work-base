<template>
    <el-upload
            class=""
            :on-preview="handlePreview"
            :action="uploadUrl"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            :on-success="uploadSuccess"
            multiple
            :file-list="vals"
            name="file"
            :show-file-list="false"
            :headers="headers"
    >
        <el-button size="small" type="primary">点击上传</el-button>
        <div slot="tip" class="el-upload__tip"></div>
    </el-upload>
</template>
<script>

    export default {
        props:['value'],
        data(){
            return {
                uploadUrl: this.SITE_URL + '/api/admin/file/upload',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('accessToken')
                },
                disabled: false,
                vals: [],
                updated: []
            }
        },
        methods:{
            handlePreview(){},
            beforeRemove(file, fileList) {
                return this.$confirm(`确定移除 ${ file.name }？`);
            },
            preview(file){
                window.open(file.response.data.file)
            },
            handleRemove(file, fileList){
                this.updated = this.vals.filter( item => { return item.url != file.url} );
                this.$emit('input', this.updated)
//                this.vals = updated
            },
            uploadSuccess(response, file, fileList){
                const item = {name: file.name, url: response.data.file}
                this.updated = [...this.vals, item]
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
</style>
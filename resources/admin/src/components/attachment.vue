<template>
    <el-upload
            class=""
            :action="uploadUrl"
            :on-remove="handleRemove"
            :before-remove="beforeRemove"
            :on-success="uploadSuccess"
            :on-preview="handlePreview"
            :on-error="uploadError"
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
                disabled: false,
                fileList: []
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
        watch:{
            value(){
                if(this.value instanceof  Array){
                    this.fileList = this.value.map((item) => {
                        let {name, url} = item;
                        return {name, url}
                    })
                }
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
            uploadSuccess(response, file){
                const item = {name: file.name, url: file.response.data.file}
                this.fileList = [...this.fileList, item].map(item => {
                    let {name, url} = item;
                    return {name, url}
                });
                this.$emit('input', this.fileList)
            },
            async uploadError(){
                this.$message.error('本次上传出错请重新上传');
                await this.$store.dispatch(this.$types.csrf)
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
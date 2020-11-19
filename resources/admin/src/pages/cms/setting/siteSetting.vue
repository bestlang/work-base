<template>
	<div>
		<div class="l-block">
			<div class="l-block-header">
				<div>
					<span>站点设置</span>
				</div>
			</div>
			<div class="l-block-body">
				<div style="width: 70%">
					<el-form label-width="120px">
						<el-form-item label="网站标题">
							<el-input v-model="site.title"></el-input>
						</el-form-item>
						<el-form-item label="网站描述">
							<el-input type="textarea" v-model="site.description"></el-input>
						</el-form-item>
						<el-form-item label="网站关键字">
							<el-input v-model="site.keywords"></el-input>
						</el-form-item>
						<el-form-item label="网站主题">
							<el-select v-model="site.theme" placeholder="请选择">
								<el-option
										v-for="(item, index) in themes"
										:key="index"
										:label="item"
										:value="item">
								</el-option>
							</el-select>
						</el-form-item>
						<el-form-item>
							<el-button type="primary" size="small" @click="saveContent">提交</el-button>
						</el-form-item>
					</el-form>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    import api from 'sysApi'

	export default {
        name: 'cmsSettingSiteSetting',
	    data(){
	        return {
	            themes: [],
	            site: {
	                title: '',
                    description: '',
					keywords: '',
					theme:''
				}
			}
		},
		methods:{
            async getOptionalThemes(){
                let res = await api.getOptionalThemes()
				if(!res.hasError){
                    this.themes = res.data;
				}else{
                    this.$message.info(res.error)
				}
			},
            async getSiteSetting(){
                let res = await api.getSiteSetting()
				if(res.hasError){
                    this.$message.error(res.error)
				}
                this.site = Object.assign({}, this.site, res.data)
            },
		    async saveContent(){
                let res = await api.saveSiteSetting(this.site)
				if(res.hasError){
					this.$message.error(res.error);
                }else{
                    this.$message.success(res.data);
				}
				// console.log(JSON.stringify(this.site))
			}
		},
		async created(){
	        await this.getOptionalThemes()
			await this.getSiteSetting()

		}
	}
</script>
<style scoped lang="less">

</style>
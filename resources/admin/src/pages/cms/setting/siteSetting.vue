<template>
	<div>
		<!--<div>站点标题</div>-->
		<!--<div>站点描述</div>-->
		<!--<div>站点关键字</div>-->
        <!--<div>备案信息设置</div>-->
        <!--<div>模板路径设置</div>-->
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
    import api from '../../../api/index'
	export default {
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
                    this.showMessage(res.error)
				}
			},
            async getSiteSetting(){
                let res = await api.getSiteSetting()
				if(res.hasError){
                    this.showMessage(res.error)
				}
                this.site = Object.assign({}, this.site, res.data)
            },
		    async saveContent(){
                let res = await api.saveSiteSetting(this.site)
				if(res.hasError){
					this.$message({
						type: 'error',
						message: res.error
					});
                }else{
                    this.$message({
                        type: 'success',
                        message: res.data
                    });
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
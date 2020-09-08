<template>
	<div class="l-channel-list">
		<div v-title="'职位管理'"></div>
		<div class="l-tree-container">
			<position-tree  :selectedKey="2" @nodeClick="handleNodeClick"></position-tree>
		</div>
		<div class="l-tree-content">
			<div class="l-block">
				<div class="l-block-header">
					<div class="l-flex">
						<span>员工系统 / 职位管理</span>
						<el-button type="primary" @click="add"><i class="iconfont">&#xe663;</i>新增</el-button>
					</div>
				</div>
				<div class="l-block-body">

				</div>
			</div>
		</div>
	</div>
</template>

<script>
    import PositionTree from "../components/PositionTree"

	export default {
        components: { PositionTree },
	    data(){
	        return {
				id: 0,
				children: []
			}
		},
		methods:{
            handleNodeClick(node){
				let indeed  = node[0]
				if(indeed.children.length){
				    this.children = indeed.children
				}
			},
            add(){
                this.$router.push('/basic/position/edit')
            }
		},
        async mounted(){
            this.id = parseInt(this.$route.query.id) || 0;
        }
	}
</script>

<style scoped lang="less">
	.l-channel-list{
		display: flex;
		flex-flow: row nowrap;
		min-height: calc(100vh - 50px - 20px);
		margin:-20px 0 -20px -20px;
		overflow-x: hidden;
		.l-tree-containner{
			min-width: 200px;
			padding: 20px;
			border-right: 1px solid #f4f4f4;
			flex-shrink: 0;
			height: 100%;
			overflow-y: auto;
		}
		.l-tree-content{
			padding: 20px;
			flex-grow: 1;
			display: flex;
			flex-flow: row nowrap;
			box-sizing: border-box;
			width: calc(100% - 240px);
		}
	}
</style>
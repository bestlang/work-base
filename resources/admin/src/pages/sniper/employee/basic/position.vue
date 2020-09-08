<template>
	<div class="l-channel-list">
		<div v-title="'职位管理'"></div>
		<div class="l-tree-container">
			<position-tree  :selectedKey="2" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded"></position-tree>
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
					<el-table
							v-loading="loading"
							:data="children"
							style="width: 100%">
						<el-table-column
								prop="id"
								label="ID"
								width="80">
						</el-table-column>
						<el-table-column
								prop="name"
								label="职位名">
						</el-table-column>
						<el-table-column
								prop="department.name"
								label="所属部门">
						</el-table-column>
						<el-table-column
								label="操作">
							<template slot-scope="scope">
								<el-button type="text">编辑</el-button>
								<el-button type="text">新增子栏目</el-button>
								<el-button type="text">删除</el-button>
							</template>
						</el-table-column>
					</el-table>
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
				children: [],
                loading: false
			}
		},
		methods:{
            performTreeLoaded(children){
                this.children = children
			},
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
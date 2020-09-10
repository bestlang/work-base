<template>
	<div class="l-position-list">
		<div v-title="'职位管理'"></div>
			<position-tree  :selectedKey="2" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded"></position-tree>
		<div class="l-tree-content">
			<div class="l-block">
				<div class="l-block-header">
					<div class="l-flex">
						<!--<span>员工系统 / 职位管理</span>-->
						<span><i class="iconfont">&#xe611;</i> {{position.hasOwnProperty('name') ? position.name : ''}}</span>
						<el-button-group>
							<el-button type="primary" size="small" @click="edit"><i class="iconfont">&#xe618;</i>编辑</el-button>
							<el-button type="success" size="small" @click="add"><i class="iconfont">&#xe663;</i>新增</el-button>

						</el-button-group>
					</div>
				</div>
				<div class="l-block-body">
					<el-table
							v-loading="loading"
							:data="position.children"
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
								prop="parent.name"
								label="上级职位名">
						</el-table-column>
						<el-table-column
								prop="department.name"
								label="所属部门">
						</el-table-column>
						<el-table-column
								prop="desiring"
								label="所需员工">
						</el-table-column>
						<el-table-column
								label="操作">
							<template slot-scope="scope">
								<el-button type="text" @click="editPosition(scope.row)">编辑</el-button>
								<!--<el-button type="text" @click="addPosition(scope.row)">新增下属职位</el-button>-->
								<el-button type="text" @click="deletePosition(scope.row)">删除</el-button>
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
    import api from '@/api/index'

	export default {
        components: { PositionTree },
	    data(){
	        return {
				id: 0,
				position:{},
                loading: false
			}
		},
		methods:{
            performTreeLoaded(position){
                this.position = position
			},
            handleNodeClick(node){
				let position  = node
				this.position = position
			},
			edit(){
                this.$router.push('/sniper/employee/position/edit?id='+this.position.id)
			},
            add(){
                let {id} = this.position
                this.$router.push('/sniper/employee/position/edit?parent_id='+id)
            },
            editPosition({id}){
                this.$router.push('/sniper/employee/position/edit?id='+id)
			},
            addPosition({id}){
                this.$router.push('/sniper/employee/position/edit?parent_id='+id)
			},
            async deletePosition({id}){
                this.$confirm('确定删除职位?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(async () => {
                    let res = await api.sniperDeletePosition({id})
                    if(!res.hasError){
                        this.showMessage('删除成功！', 'success')
                    }
                });

			}
		},
        async mounted(){
            this.id = parseInt(this.$route.query.id) || 0;
        }
	}
</script>

<style scoped lang="less">
	.l-position-list{
		display: flex;
		flex-flow: row nowrap;
		min-height: calc(100vh - 50px - 20px);
		margin:-20px 0 -20px -20px;
		overflow-x: hidden;
		.l-tree-container{
			min-width: 200px;
			padding: 20px;
			border-right: 1px solid #f4f4f4;
			flex-shrink: 0;
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
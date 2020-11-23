<template>
	<div class="l-position-list">
		<div v-title="'职位管理'"></div>
		<position-tree class="l-tree" :selectedKey="2" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded"></position-tree>
		<div class="l-tree-content">
			<div class="l-block">
				<div class="l-block-header" style="padding-right: 20px;width: 100%;">
					<div class="l-flex">
						<!--<span>员工系统 / 职位管理</span>-->
						<span><i class="iconfont">&#xe611;</i> 职位-{{position.name ? position.name : ''}}</span>
						<el-button-group>
							<el-button type="primary" size="small" @click="edit"><i class="iconfont">&#xe618;</i>编辑</el-button>
							<el-button type="success" size="small" @click="add"><i class="iconfont">&#xe663;</i>新增</el-button>
						</el-button-group>
					</div>
				</div>
				<div class="l-block-body l-lighter">
					<p class="l-position-meta">职位名称：{{position.name ? position.name : ''}}</p>
					<p class="l-position-meta">上级职位：{{position.parent ? position.parent.name : '-'}}</p>
					<p class="l-position-meta">所属部门：{{position.department ? position.department.name : ''}}</p>
					<p class="l-position-meta">职位人员：</p>
					<el-table
							v-show="employee"
							:data="employee"
							empty-text="暂无职位人员"
							border
							style="width: 100%">
						<!--<el-table-column-->
								<!--prop="user_id"-->
								<!--label="ID"-->
								<!--width="80">-->
						<!--</el-table-column>-->
						<el-table-column
								prop="real_name"
								label="姓名">
						</el-table-column>
						<el-table-column
								prop="department.name"
								label="所属部门">
						</el-table-column>
						<el-table-column
								label="操作">
							<template slot-scope="scope">
								<el-button type="primary" size="mini" @click="viewUser(scope.row)">查看</el-button>
							</template>
						</el-table-column>
					</el-table>
					<p class="l-position-meta" style="padding-top: 10px;">下属职位：</p>
					<el-table
							v-show="position"
							v-loading="loading"
							:data="position.children"
							empty-text="暂无下属职位"
							border
							style="width: 100%">
						<!--<el-table-column-->
								<!--prop="id"-->
								<!--label="ID"-->
								<!--width="80">-->
						<!--</el-table-column>-->
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
								<el-button class="l-lighter" size="mini" type="primary" @click="editPosition(scope.row)">编辑</el-button>
								<el-button class="l-lighter" size="mini" type="danger" @click="deletePosition(scope.row)">删除</el-button>
							</template>
						</el-table-column>
					</el-table>

				</div>
			</div>
		</div>
		<el-dialog title="人员信息" :visible.sync="drawer">
			<div style="padding: 0 20px;overflow-y: scroll;height: 100%;">
				<div class="l-position-meta">
					<div>姓名：{{user.real_name}}</div>
					<div>身份证号：{{user.id_card}}</div>
					<div>手机号：{{user.phone}}</div>
					<div>公司邮箱：{{user.user && user.user.email}}</div>
					<div><a  target="_blank" :href="`/#/sniper/employee/employee/edit?employee_id=`+user.user_id"><i class="if">&#xe603;</i>查看详情</a></div>
				</div>
			</div>
		</el-dialog>
	</div>
</template>

<script>
    import PositionTree from "../components/PositionTree"
    import api from 'sysApi'

	export default {
        name: 'sniperEmployeeBasicPosition',
        components: { PositionTree },
	    data(){
	        return {
	            drawer: false,
				id: 0,
				position:{},
				employee:[],
				user:{},
                loading: false
			}
		},
		watch:{
            position:{
            	deep: true,
				async handler(newVal){
            	    await this.getPositionDetail(newVal.id)
				}
			}
		},
		methods:{
            viewUser(user){
                this.drawer = !this.drawer
                this.user = user
			},
            async getPositionDetail(id){
                let {data} = await api.sniperGetPositionDetail({id});
                this.employee = [].concat(data.employee)
            },
            async performTreeLoaded(position){
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
                    type: 'error'
                }).then(async () => {
                    let res = await api.sniperDeletePosition({id})
                    if(!res.hasError){
                        this.$message.success('删除成功！')
						this.position.children = this.position.children.filter(function(p){
						    return p.id != id
						})
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
	.l-position-meta{
		color:#606266;
		padding-bottom: 10px;
		>div{
			padding-bottom: 10px;
		}
	}
	.l-position-list{
		display: flex;
		flex-flow: row nowrap;
		min-height: calc(100vh - 50px - 20px);
		margin:-20px 0 -20px -20px;
		overflow-x: hidden;
		box-sizing: border-box;
		.l-tree{
			padding: 10px 20px;
			border-right: 1px solid #f4f4f4;
			flex-shrink: 0;
			overflow:auto;
			width: 300px;
		}
		.l-tree-content{
			/*padding: 20px;*/
			flex-grow: 1;
			display: flex;
			flex-flow: row nowrap;
			box-sizing: border-box;
			/*min-width: 1200px;*/
			flex-shrink: 20;
		}
	}
</style>
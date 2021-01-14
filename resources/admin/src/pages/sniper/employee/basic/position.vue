<template>
	<div class="l-position-list">
		<div v-title="'职位管理'"></div>
		<position-tree class="l-tree" :selectedKey="2" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded"></position-tree>
		<div class="l-tree-content">
			<div class="l-block">
				<div class="l-block-body l-lighter">
                    <el-tabs v-model="activeName" type="border-card">
                        <el-tab-pane label="职位信息" name="first">
                            <div class="text-right pb-15">
                                <el-button type="primary" size="small" @click="edit(position)"><i class="iconfont">&#xe618;</i> 编辑</el-button>
                                <el-button type="danger" size="small" @click="del(position)"><i class="iconfont">&#xe620;</i> 删除</el-button>
                            </div>
                            <p class="l-position-meta">职位名称：{{position.name ? position.name : ''}}</p>
                            <p class="l-position-meta">上级职位：{{position.parent ? position.parent.name : '-'}}</p>
                            <p class="l-position-meta">所属部门：{{position.department ? position.department.name : ''}}</p>
                        </el-tab-pane>
                        <el-tab-pane label="职位人员" name="second">
                            <el-table
                                    v-show="employee"
                                    :data="employee"
                                    empty-text="暂无职位人员"
                                    border
                                    style="width: 100%">
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
                        </el-tab-pane>
                        <el-tab-pane label="下属职位管理" name="third">
                            <div class="text-right pb-15">
                                    <el-button type="success" size="small" @click="add(position)"><i class="iconfont">&#xe663;</i>新增</el-button>
                            </div>
                            <el-table
                                    v-show="position"
                                    v-loading="loading"
                                    :data="position.children"
                                    empty-text="暂无下属职位"
                                    border
                                    style="width: 100%">
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
                                        <el-button class="l-lighter" size="mini" type="primary" @click="edit(scope.row)">编辑</el-button>
                                        <el-button class="l-lighter" size="mini" type="danger" @click="del(scope.row)">删除</el-button>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </el-tab-pane>
                        <el-tab-pane label="岗位胜任力" name="fourth">
                            <div class="text-left pb-15">
                                <el-button circle type="primary" size="small" icon="el-icon-plus"></el-button>
                            </div>
                            <div>
                                <el-card class="box-card">
                                    <div slot="header" class="clearfix">
                                        <span>技术能力</span>
                                        <div>
                                            <el-button-group>
                                                <el-button size="small" type="primary" style="float: right;">新增</el-button>
                                                <el-button size="small" type="danger" style="float: right;">删除</el-button>
                                            </el-button-group>
                                        </div>
                                    </div>
                                    <el-table
                                            :data="tableData"
                                            border
                                            style="width: 100%">
                                        <el-table-column
                                                prop="date"
                                                label="分类"
                                                width="180">
                                        </el-table-column>
                                        <el-table-column
                                                prop="name"
                                                label="能力名"
                                                width="180">
                                        </el-table-column>
                                        <el-table-column
                                                prop="address"
                                                label="能力详情">
                                        </el-table-column>
                                        <el-table-column
                                                prop="totalScore"
                                                label="能力分值">
                                        </el-table-column>
                                        <el-table-column
                                                prop="okScore"
                                                label="达标分值">
                                        </el-table-column>
                                        <el-table-column
                                                label="达标分值">

                                        </el-table-column>
                                    </el-table>
                                </el-card>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
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
					<div><a  target="_blank" :href="`/#/sniper/employee/employee/edit?employee_id=`+user.user_id" class="l-active"><i class="if">&#xe603;</i>查看详情</a></div>
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
                categories: [
                    {name: '技术能力'},
                    {name: '沟通能力'}
                ],
                activeName: 'first',
	            drawer: false,
				id: 0,
				position:{},
				employee:[],
				user:{},
                loading: false,
                tableData: [{
                    date: '技术能力',
                    name: '做事情',
                    address: '能干活',
                    totalScore: 5,
                    okScore: 4
                }, {
                    date: '技术能力',
                    name: '做事情',
                    address: '能干活',
                    totalScore: 5,
                    okScore: 4
                }, {
                    date: '技术能力',
                    name: '做事情',
                    address: '能干活',
                    totalScore: 5,
                    okScore: 4
                }, {
                    date: '技术能力',
                    name: '做事情',
                    address: '能干活',
                    totalScore: 5,
                    okScore: 4
                }]
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
			edit({id}){
                this.$router.push('/sniper/employee/position/edit?id='+id)
			},
           add({id}){
                this.$router.push('/sniper/employee/position/edit?parent_id='+id)
            },
            async del({id, name}){
                this.$confirm('确定删除`'+name+'`职位?', '提示', {
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
                    }else{
                        this.$message.error(res.error)
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
    .l-category-wrap{
        display: flex;
        flex-flow: row wrap;
        justify-content: flex-start;
        .l-category{
            position: relative;
            box-shadow: #67C23A;
            height: 30px;
            line-height: 30px;
            border:1px solid #f1f1f1;
            width: 120px;
            margin: 20px 30px 0 0;
            border-radius: 2px;
            cursor: pointer;
            background: #F2F8FE;
            padding-left: 10px;
            &:hover{
                box-shadow: 3px 3px 6px #FAFAFA;
                background: #fcf8e3;
                h1{
                    color: #888;
                }
            }
            h1{
                font-size: 14px;
                color: #888;
                padding: 10px 0 0 10px;
                font-weight: bold;
                font-weight: lighter;
            }
        }
    }
	.el-table th, .el-table tr{
		background: transparent;
	}
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
<template>
	<div class="l-position-list">
		<div v-title="'员工列表'"></div>
		<department-tree  :selectedKey="2" @nodeClick="handleNodeClick" @treeLoaded="performTreeLoaded"></department-tree>
		<div class="l-block">
			<div class="l-block-header">
				<div class="l-flex">
					<span><i class="iconfont">&#xe69a;</i> {{department.hasOwnProperty('name') ? department.name : ''}}全员</span>
					<el-button-group>
						<el-button type="success" @click="add" size="small"><i class="iconfont">&#xe663;</i>新增</el-button>
					</el-button-group>
				</div>
			</div>
			<div class="l-block-body">
				<div class="l-employee-wrap">
					<template v-if="employee.length">
						<div class="l-employee" v-for="(em, index) in employee"  :key="index" @click="viewEmployee(em)">
							<img :src="em.avatar?'http://127.0.0.1:8000/'+em.avatar : '/vendor/sniper/user.png'" alt="">
							<h1 class="l-title">{{em.real_name}}</h1>
							<!--({{em.position.name}})-->
							<div style="font-size: 10px;">{{em.user.email}}</div>
						</div>
					</template>
					<div v-else style="text-align: center;color: #ccc;width: 100%;">暂无人员</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    import DepartmentTree from "../components/DepartmentTree"
    import api from "@/api/index"

    export default {
        components: { DepartmentTree },
        data(){
            return {
                department: {},
				employee:[]
            }
        },
		watch:{
            async ['department.id'](val){
                await this.getDepartmentEmployee()
			}
		},
        methods:{
            viewEmployee({user_id}){
                this.$router.push('/sniper/employee/employee/edit?employee_id='+user_id)
			},
			add(){
				let {id} = this.department
				this.$router.push('/sniper/employee/employee/edit?department_id='+id)
			},
            handleNodeClick(node){
                this.department = node
                console.log(node)
            },
            performTreeLoaded(department){
                this.department = department
            },
			async getDepartmentEmployee(){
			    let departmentId = this.department.id
			    let {data} = await api.sniperGetDepartmentEmployee({departmentId})
				this.employee = data
			}
        },
        async mounted(){

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
	.l-block{
		padding-left: 20px;
	}
	.l-employee-wrap{
		display: flex;
		flex-flow: row wrap;
		justify-content: flex-start;
		.l-employee{
			padding: 10px;
			position: relative;
			box-shadow: #67C23A;
			/*height: 140px;*/
			border:1px solid #eee;
			width: 200px;
			height: 140px;
			margin: 20px 30px 0 0;
			border-radius: 5px;
			cursor: pointer;
			background: #F2F8FE;
			/*
			 height: 140px;
            border:1px solid #f1f1f1;
            width: 220px;
            margin: 20px 30px 0 0;
			*/
			img{
				width: 60px;
				height: 60px;
			}
			&:hover{
				box-shadow: 3px 3px 6px #f1f1f1;
				background: #fcf8e3;
				h1{
					color: #2d2d2d;
				}
			}
			h1{
				font-size: 14px;
				color: #777;
				padding: 10px 0 0 0;
				font-weight: bold;
			}
		}
	}
</style>
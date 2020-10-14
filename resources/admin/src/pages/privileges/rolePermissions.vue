<template>
    <div>
        <div class="l-block">
            <div class="l-block-header">
                <div style="display: inline-block;">
                    <router-link to="/privileges/roles" tag="span"><span class="iconfont">&#xe601;</span>返回</router-link>
                    <el-divider direction="vertical"></el-divider>
                    <span><span v-if="currentRole">「{{currentRole.name}}」</span>权限</span>
                </div>
                <div><el-button @click="saveRolePermissions" type="primary">保存</el-button></div>
            </div>
            <div class="l-block-body">
                <div>
                    <div style="width:60%;">
                        <el-tree
                                :empty-text="emptyText"
                                ref="role-permission-tree"
                                :data="treeData"
                                default-expand-all
                                show-checkbox
                                node-key="id"
                                :props="customProps"
                                :default-checked-keys="defaultCheckedKeys"
                                :expand-on-click-node="false"
                                :check-on-click-node="false">
                                <span class="custom-tree-node" slot-scope="{ node, data }">
                                    <span :style="{letterSpacing: node.isLeaf ? '0.2px': Math.abs(node.level - 10)*0.2+'px', fontSize:Math.max((22 - node.level*2), 13)+'px'}">{{ node.label }}</span>
                                </span>
                        </el-tree>
                    </div>
                    <div class="l-delimiter"></div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import api from 'sysApi'
    import {mapGetters} from 'vuex'
    import types from 'sysType'

    export default {
      data() {
        return {
          emptyText: 'loading...',
          role_id: null,
          defaultCheckedKeys: [],
          total: 0,
          tableData: [],
          customProps: {
            children: 'children',
            label: 'show_name'
          },
          treeData:[],
          currentRole: null,

          current:null,
          dialogFormVisible: false,
          title: '添加子权限',
          form:{
            id: '',
            parent_id: '',
            name: '',
            show_name: ''
          }
        }
      },
      computed:{
          ...mapGetters(['user'])
      },
      watch:{
          async role_id(val){
              await this.loadRolePermissions(val)
               await this.getRole(val)
          }
      },
      methods: {
        async saveRolePermissions(){
            let nodes = this.$refs['role-permission-tree'].getCheckedNodes()
            let permissions = nodes.filter((n)=>n.children.length == 0).map((n) => n.id ? n.id : '')
            let role_id = this.currentRole.id
            let res = await api.givePermissionsTo({permissions, role_id})
            let {logout} = res.data
            let msg = '设置成功!'
            if(logout){
                msg += ' 请重新登录'
                setTimeout(() => {this.$store.dispatch(types.logout)}, 1500)
            }
            this.$message({
                type: 'success',
                message: msg
            })
        },
        async loadPermissionsTree(){
          let res = await api.getPermissionsTree()
          this.treeData = [res.data[Object.keys(res.data)[0]]]
        },
        async getRole(role_id){
            let {data} = await api.getRole({role_id})
            this.currentRole = data
        },
        async loadRolePermissions(role_id){
          let res = await api.getRolePermissions({role_id})
          this.defaultCheckedKeys = res.data
        },
        async loadUserPermissions(){
          let res = await api.getUserPermissions()
          localStorage.setItem(`privileges`, JSON.stringify(res))
        }
      },
      async mounted() {
        this.role_id = parseInt(this.$route.query.role_id)  || 0
        await this.loadPermissionsTree()
      }
    }
</script>
<style scoped>
  .custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;
    padding-right: 5px;
      line-height: 20px;
  }
  >>> /deep/ .el-tree-node{
  padding: 0;
  }
  >>> /deep/ .el-tree-node__content{
    height: 24px;
      line-height: 24px;
  }
</style>

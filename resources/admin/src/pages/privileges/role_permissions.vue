<template>
    <div>
        <div class="top-buttons" style="display: flex;flex-flow: row nowrap; justify-content: space-between;">
            <div>{{role_name}}权限</div>
            <el-button @click="$router.push({path: '/privileges/roles'})"><span class="iconfont">&#xe665;</span></el-button>
        </div>
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
              :check-on-click-node="false"
              :indent="40">
              <span class="custom-tree-node" slot-scope="{ node, data }">
                <span>{{ node.label }}-{{ data.id }}</span>
              </span>
            </el-tree>
          </div>
          <div class="l-delimiter"></div>
          <el-button @click="saveRolePermissions">保存</el-button>
        </div>
    </div>
</template>
<script>
    export default {
      data() {
        return {
          emptyText: '数据准备中...',
          role_id: null,
          role_name: null,
          defaultCheckedKeys: [],
          total: 0,
          tableData: [],
          customProps: {
            children: 'children',
            label: 'show_name'
          },
          treeData:[],

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
        types(){
          return this.$store.getters.activityTypes;
        }
      },
      methods: {
        saveRolePermissions(){
          let nodes = this.$refs['role-permission-tree'].getCheckedNodes();
          let permissions = nodes.filter((n)=>n.children.length == 0).map((n) => n.id);//.filter((n) => !n.children.length)
          // console.log(`---------------->:`, permissions)
          // return;
          let role_id = this.role_id
          this.$http
            .post("/admin/privileges/give/permissions/to", {permissions, role_id})
            .then(res => {
              this.$message({
                type: 'success',
                message: '设置成功!'
              });
            }).catch(err => {});
        },
        loadPermissionsTree(){
          this.$http
            .get("/admin/privileges/permissions/tree")
            .then(res => {
              this.treeData = [res.data[Object.keys(res.data)[0]]];
            });
        },
        loadRolePermissions(){
          let role_id = this.role_id;
          this.$http
            .get("/admin/privileges/role/permissions", {params: {role_id}})
            .then(res => {
              this.defaultCheckedKeys = res.data;
            });
        },
        loadUserPermissions(){
          this.$http
            .get("/admin/privileges/user/permissions")
            .then(res => {
              console.log(`:::>>>`, JSON.stringify(res))
              localStorage.setItem(`privileges`, JSON.stringify(res));
            });
        }
      },
      mounted() {
        this.role_id = this.$route.params.id;
        this.role_name = this.$route.params.name;
        this.loadRolePermissions();
        this.loadPermissionsTree();
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
    padding-right: 8px;
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
</style>

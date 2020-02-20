<template>
    <div>
        <div class="top-buttons" style="display: flex;flex-flow: row nowrap;">
          <router-link to="/privileges/roles" tag="div"><span class="iconfont">&#xe601;</span>返回</router-link>
          <el-divider direction="vertical"></el-divider>
          <div>{{role_name}}权限</div>
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
                :expand-on-click-node="true"
                :check-on-click-node="false">
                <span class="custom-tree-node" slot-scope="{ node, data }">
                  <span>{{ node.label }}</span>
  <!--                <span v-if="!data.children.length" class="iconfont">&#xe92a;</span>-->
  <!--                -{{ data.id }}-->
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
          emptyText: 'loading...',
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
        },
        currentRole(){
          return this.$store.getters.currentRole;
        }
      },
      methods: {
        saveRolePermissions(){
          let nodes = this.$refs['role-permission-tree'].getCheckedNodes();
          let permissions = nodes.filter((n)=>n.children.length == 0).map((n) => n.id);
          let role_id = this.currentRole.id
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
          let role_id = this.currentRole.id;
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
    font-size: 16px;
    padding-right: 8px;
  }
  .el-tree-node__content{
    border-bottom: 1px solid #f4f4f4;
    height: 32px;
    line-height: 32px;
  }
</style>

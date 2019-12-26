<template>
    <div>
        <div class="top-buttons" style="text-align: right">
            <el-button @click="$router.push({path: '/privileges/roles'})"><span class="iconfont">&#xe665;</span></el-button>
        </div>
    </div>
</template>
<script>
    export default {
      data() {
        return {
          total: 0,
          tableData: []
        }
      },
      computed:{
        types(){
          return this.$store.getters.activityTypes;
        }
      },
      methods: {
        handleEdit(row){
        },
        handleDelete(row){
        },
        loadRoles(){
          this.$http
            .get("/admin/privileges/role/users/"+this.$route.params.id)
            .then(res => {
              this.tableData = res.data;
            });
        }
      },
      mounted() {
        this.loadRoles()
      }
    }
</script>

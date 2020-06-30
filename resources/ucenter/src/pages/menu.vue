<template>
    <el-container>
        <el-row :gutter="10" style="width: 1200px;margin: 0 auto;">
            <el-col :xs="24" :sm="6" :md="6" :lg="6" :xl="6"><div class="grid-content bg-purple-light">
                asdasda
            </div></el-col>
            <el-col :xs="24" :sm="18" :md="18" :lg="18" :xl="18"><div class="grid-content bg-purple">
                asdasd
            </div></el-col>
        </el-row>
    </el-container>
</template>

<script>
    export default{
        name: 'meun',
        data() {}
    }
</script>

<style>
    .el-col {
        border-radius: 4px;
    }
    .bg-purple-dark {
        background: #99a9bf;
    }
    .bg-purple {
        background: #d3dce6;
    }
    .bg-purple-light {
        background: #e5e9f2;
    }
    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }
</style>
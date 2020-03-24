<template>
    <el-container class="ls-container">
        <div class="ls-aside">
            <div class="ls-left">
                <backend-menu></backend-menu>
            </div>
        </div>
        <div class="ls-content">
            <div class="ls-top">
                <backend-top></backend-top>
            </div>
            <div class="ls-main">
                <div style="box-sizing: border-box;background: #fff;padding: 20px;box-sizing: border-box;min-height: 100%;">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </el-container>
</template>
<script>
import top from "./partials/top.vue"
import menu from "./partials/menu.vue"

export default {
    components: {
        "backend-top": top,
        "backend-menu": menu
    },
    computed: {
        isCollapse() {return this.$store.state.system.isCollapse}
    },
    mounted(){

    }
}
</script>
<style scoped lang="less">
    .ls-container{
        margin: 0;
        display: flex;
        flex-flow: row nowrap;
    }
    .ls-aside{
        flex-shrink: 0;
        border-right: 1px solid #e6e6e6;
    }
    .ls-top{
        height: 50px;
        background: #fff;
        width: 100%;
        border-bottom:1px solid #e0e4e9;
        z-index: 2;
    }
    .ls-content{
        width: 100%;
        flex-basis: auto;
        overflow-x: hidden;
    }
    .ls-left{
        text-align: left;
        position: relative;
    }

    .ls-main{
        height: calc(100vh - 50px);
        padding: 10px;
        overflow-y: scroll;
        /*background: rgb(244, 244, 244);*/
        /*background-color: #F5F7FA;*/
        /*background-color: #f8f8f8;*/
    }
</style>

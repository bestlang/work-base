<template>
    <el-container class="ls-container">
        <el-aside class="ls-aside" :width="width">
                <backend-menu></backend-menu>
        </el-aside>
        <div class="ls-content">
            <div class="ls-top">
                <backend-top>
                    <template slot="center-nav">
                        <tag-nav></tag-nav>
                    </template>
                </backend-top>
            </div>
            <div class="ls-main">
                <div class="ls-main-inner">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </el-container>
</template>
<script>
import top from './partials/top'
import menu from './partials/menu'
import tagNav from './tagNav'

export default {
    components: {
        'backend-top': top,
        'backend-menu': menu,
        tagNav
    },
    computed: {
        width(){ return this.isCollapse ? '64px' : '200px'},
        isCollapse() {return this.$store.state.normal.isCollapse}
    },
    mounted(){}
}
</script>
<style scoped lang="less">
    /*/deep/ .el-tabs{*/
        /*width: 100%;*/
    /*}*/
    .ls-container{
        margin: 0;
        display: flex;
        flex-flow: row nowrap;
    }
    .ls-top{
        height: 40px;
        background: #fff;
        width: 100%;
        border-bottom: 1px solid rgb(228, 231, 237);
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
        height: calc(100vh - 40px);
        padding: 10px;
        overflow-y: scroll;
        .ls-main-inner{
            box-sizing: border-box;
            background: #fff;
            padding: 20px;
            box-sizing: border-box;
            min-height: 100%;
        }
    }
</style>
<style lang="less" scoped>
    .grid-content{
        color: #fff;
        border-radius: 6px;
        padding: 20px 30px;
    }
</style>

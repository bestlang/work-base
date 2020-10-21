<template>
    <el-container class="ls-container">
        <div class="ls-aside">
            <div class="ls-left">
                <backend-menu></backend-menu>
            </div>
        </div>
        <div class="ls-content">
            <div class="ls-top">
                <backend-top>
                    <template slot="top-items">
                        <!--
                        <div class="l-top-item" :class="{active: true}" style="margin-left: 60px;"><i class="iconfont">&#xe618;</i> CMS</div>
                        <div class="l-top-item"><i class="iconfont">&#xe92a;</i> 问答</div>
                        <div class="l-top-item"><i class="iconfont">&#xe62f;</i> 商城</div>
                        -->
                    </template>
                    <template slot="center-nav">
                        <tag-nav style="line-height: 50px"></tag-nav>
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
        isCollapse() {return this.$store.state.system.isCollapse}
    },
    mounted(){}
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
        /*border-right: 1px solid #e6e6e6;*/
    }
    .ls-top{
        /*box-shadow: 0 1px 5px rgba(0, 0, 0, 0.10);*/
        height: 50px;
        background: #fff;
        width: 100%;
        /*border-bottom:1px solid #e0e4e9;*/
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

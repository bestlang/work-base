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
    }
    .ls-top{
        height: 50px;
        background: #fff;
        width: 100%;
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
